<?php


namespace victor\sample2;



class ClasaMare {

    // private bool $wasDiscountApplied;
    // private float $price; // raw or discounted price
    // private float $shippingCost; // raw or discounted price

    private ?RawPrice $rawPrice;
    private ?DiscountedPrice $discountedPrice;
    function wasDiscounted(): bool {
        return $this->discountedPrice!= null;
    }
}
class RawPrice {
    private float $price;
    private float $shippingCost;
    private float $shippingCostWithoutVAT;
}
class DiscountedPrice {
    private float $price;
    private float $shippingCost;
    private float $shippingCostWithoutVAT;
    private float $fidelityPoints;
}

class Sample2
{
    public function process(PostProcessDeliveryLineQuantitiesDto $postProcessDeliveryLineQuantitiesDto): void
    {
        $this->stopwatcihService->start(static::STOPWATCH_KEY);

        $statsdTimer = $this->statsdServce->startTimer(static::STOPWATCH_KEY);

        $postProcessPickingTasksData = [];

        try {
            $deliveryLineQuantities = $this->loadDeliveryLineQuantitiesToProcess($postProcessDeliveryLineQuantitiesDto->getDeliveryLineQuantityIds());

            $postProcessPickingTasksData['deliveryLineQuantityIds'] = array_keys($deliveryLineQuantities);

            list($productIdentifiers, $tasksByProductIdentifier) = $this->mapPickingTasksByProductIdentifier($deliveryLineQuantities);

            $this->stopwatchService->lap('after loading delivery picking tasks');

            /** @var DeliveryLineQuantity $firstDeliveryLineQuantity */
            $firstDeliveryLineQuantity = reset($deliveryLineQuantities);

            $warehouseId = $firstDeliveryLineQuantity->getPickingTask()->getLocationFrom()->getWarehouseId();

            $matchingTasks = $this->findMatchingTasksByProductIdentifiers($productIdentifiers, $warehouseId);

            $tasksByProductIdentifier = $this->compareMatchingTasksToDeliveryTasks($productIdentifiers, $tasksByProductIdentifier, $matchingTasks);

            $this->stopwatchService->lap('after loading matching picking tasks');

            $distinctTaskLocationsByProductIdentifiers = $this->getDistinctTaskLocationsByProductIdentifiers($tasksByProductIdentifier);

            $tasksByProductIdentifier = $this->eliminateTasksInSingleLocation($distinctTaskLocationsByProductIdentifiers, $tasksByProductIdentifier);

            $this->stopwatchService->lap('after mapping distinct location');

            $this->acquireLock($tasksByProductIdentifier);

            /** @var EntityManager $emCommon */
            $emCommon = $this->doctrine->getManager('common');

            foreach ($tasksByProductIdentifier as $productIdentifier => $pickingTasks) {
                $filters = $this->composeFiltersForProductIdentifier($productIdentifier);

                /** @var Product $product */
                $product = $emCommon->find(Product::class, $filters['productId']);

                if ($this->productService->isPerishable($product)) {
                    continue;
                }

                $stockLines = $this->getStockForProductIdentifier($filters);

                $this->stopwatchService->lap('after finding new stock for ' . $productIdentifier);

                $pickingTaskStockReservation = $this->getPickingTaskStockReservation($pickingTasks);

                $postProcessPickingTasksData[$productIdentifier]['numberOfTaskIds'] = \count($pickingTasks) .
                    ' picking tasks reserving ' . \count(array_unique($pickingTaskStockReservation)) . ' stock lines';

                $stockReservedByPickingTasks = $this->getStockLinesReservedByPickingTasks($pickingTaskStockReservation);

                /* the 'real' available stock is available stock + stock reserved by picking tasks */
                $stockLinesAvailableQuantity = $this->computeAvailableStock($stockLines, $stockReservedByPickingTasks);
                /* sort stock lines by stock availability */
                arsort($stockLinesAvailableQuantity);

                $postProcessPickingTasksData[$productIdentifier]['availableStock'] = $stockLinesAvailableQuantity;

                $postProcessPickingTaskDtos = [];

                while (\count($pickingTasks) > 0) {
                    $postProcessPickingTasksData[$productIdentifier]['taskCount'][] = \count($pickingTasks);
                    $optimalStockId = null;
                    /* for each stock line check available against the number of tasks */
                    foreach ($stockLinesAvailableQuantity as $stockId => $availableQuantity) {
                        /* if task count is smaller that available, save that stock line as optimal stock */
                        if (\count($pickingTasks) > $availableQuantity) {
                            /* if task count is greater that available quantity */
                            /* but previous stock line satisfies entire quantity, use that stock line */
                            if (\count($pickingTasks) > $availableQuantity && $optimalStockId) {
                                break;
                            }
                            /* if task count is greater that available quantity */
                            /* and no stock line that satisfies entire quantity, use current stock line to optimise */
                            if (\count($pickingTasks) > $availableQuantity && !$optimalStockId) {
                                $optimalStockId = $stockId;
                                break;
                            }
                        }
                    }
                    foreach ($stockLinesAvailableQuantity as $stockId => $availableQuantity) {
                        /* if task count is smaller that available, save that stock line as optimal stock */
                        if (\count($pickingTasks) <= $availableQuantity) {
                            $optimalStockId = $stockId;
                        }
                    }

                    if (!$optimalStockId) {
                        throw new BaseException('Nu a functionat algoritmul');
                    }

                    $optimalStock = $stockLines[$optimalStockId];
                    /* compute tasks to reserve new optimal stock */
                    /* starting with tasks that reserve the smallest total stock */
                    $availableStock = $optimalStock->getAvailable();

                    if (isset($stockReservedByPickingTasks[$optimalStockId])) {
                        foreach ($stockReservedByPickingTasks[$optimalStockId] as $taskId) {
                            /* this is required to not move tasks that already reserve the optimal stock */
                            unset($pickingTaskStockReservation[$taskId], $pickingTasks[$taskId]);
                        }
                    }


                    foreach ($pickingTaskStockReservation as $taskId => $reservedStockId) {
                        if (0 === $availableStock) {
                            break;
                        }

                        /* move tasks to reserve new optimal stock */
                        $postProcessPickingTaskDtos[$taskId] = $this->createPostProcessPickingTaskDto(
                            $pickingTasks[$taskId],
                            $optimalStock
                        );

                        /* decrease available stock and remove optimised tasks from task list */
                        --$availableStock;
                        unset($pickingTaskStockReservation[$taskId], $pickingTasks[$taskId]);
                    }

                    $postProcessPickingTasksData[$productIdentifier]['availableStockAfterAlgoritm'][$optimalStockId] = $availableStock;
                    $postProcessPickingTasksData[$productIdentifier]['totalStock'][$optimalStockId] = $optimalStock->getTotal();

                    /* remove optimal stock line from stock lines list */
                    unset($stockLinesAvailableQuantity[$optimalStockId]);
                }

                if ($this->deliveryModule->canSavePostProcessPickingTasks($warehouseId)) {
                    $this->saveNewTasks($postProcessPickingTaskDtos);

                    $postProcessPickingTasksData[$productIdentifier]['newTaskIds'] = $this->addNewTasksInformationToLog($postProcessPickingTaskDtos);
                }
            }
        } catch (\Throwable $e) {
            $postProcessPickingTasksData['error'] = $e->getMessage();

            throw $e;
        } finally {
            $this->cleanup($postProcessPickingTasksData, $statsdTimer);
        }
    }

    /**
     * @param array $postProcessPickingTasksData
     * @param $statsdTimer
     */
    private function cleanup(array $postProcessPickingTasksData, $statsdTimer): void
    {
        $this->lockablePdoMysqlMultiService->releaseAllLocks();

        $this->stopwatchService->stop('stop', static::STOPWATCH_KEY);

        $postProcessPickingTasksData['stopwatch'] = $this->stopwatchService->getSummaries();
        $postProcessPickingTasksData['duration'] = 'DURATION: ' . round($this->stopwatchService->getDuration(static::STOPWATCH_KEY) / 1000);

        $loggerContext = [
            'service' => static::class,
            'method' => __FUNCTION__,
        ];

        $this->logger->info(ToolService::encode($postProcessPickingTasksData), $loggerContext);

        $this->writeln(ToolService::encode($postProcessPickingTasksData));

        $this->statsdService->stopTimer($statsdTimer);

        $taskCount = 0;

        if (isset($postProcessPickingTasksData['newTaskIds'])) {
            $taskCount = \count($postProcessPickingTasksData['newTaskIds']);
        }

        $this->statsdService->sendStatsdTimers(array_fill(0, $taskCount, $statsdTimer));
    }
}