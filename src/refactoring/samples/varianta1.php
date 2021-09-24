<?php
/**
 * Created by PhpStorm.
 * User: VictorRentea
 * Date: 08-Nov-18
 * Time: 03:20 PM
 */

(new X())->formatCustomerBonusPointsEntries();

class X {
    private Dbm_Order $dbmOrder;
    private Translate $translator;

    public function __construct()
    {
        $this->dbmOrder = new Dbm_Order();
        $this->translator = Dispatcher::getServiceContainer()->get('Translate');
    }

    public function formatCustomerBonusPointsEntries(int $customerID,array $cbpEntries, &$history , $today = NULL): void
    {

        foreach ($cbpEntries as $cbpEntry)
        {

            $orderID            = $cbpEntry['order_id'];
            $voucherCode        = $cbpEntry['voucher_code'];
            $bonusPointsCount   = $cbpEntry['bonus_points'];
            $cbpDate = $this->formatDotDate($cbpEntry['bp_date']);

            if ( $voucherCode )
            {
                $usedVoucher = BonusPointsHelper::isVoucherUsed( $voucherCode );
                if ( $usedVoucher )
                {
                    $cbpEntry['order_id'] = $usedVoucher['order_id'];
                }
            }


            if ( $cbpEntry['order_id'] && $cbpEntry['voucher_code'] )
            {
                // Used voucher

                $orderID        = $cbpEntry['order_id'];
                $historyEntry   = [
                    'order_id'          => $orderID,
                    'bonus_points'      => $bonusPointsCount,
                    'voucher_code'      => $voucherCode,
                    'pending'           => false,
                    'msg'               => $translator->_("Voucher was used on order") . " #$orderID",
                    'date'              => $cbpDate,
                    'voucher_was_used'  => true,
                ];
            }
            elseif ( $cbpEntry['order_id'] )
            {
                // Order-related BP allocation (Shipped order, returned order)
                  $historyEntry = $this->determineHistoryByOrderId($customerID, $cbpEntry, $today);
            }
            elseif ( $cbpEntry['voucher_code'] )
            {
                // BonusPoints => Voucher transformation (Unused voucher)
                $bpDate = $cbpEntry['bp_date'];
                if ( strlen($bpDate) > 10 )
                {
                    $bpDate = substr($bpDate, 0, 10);
                }

                $bpDateParts       = explode('-', $bpDate );
                $bpDate            = implode('.', [ $bpDateParts[2], $bpDateParts[1], $bpDateParts[0] ]);

                // TODO: Safe checking ==> isUnunsedVoucher( $voucherCode ); ??
                $historyEntry = [
                    'order_id'          => $cbpEntry['order_id'],
                    'bonus_points'      => $cbpEntry['bonus_points'],
                    'voucher_code'      => $cbpEntry['voucher_code'],
                    'pending'           => false,
                    'msg'               => $translator->_('Unused voucher'),
                    'date'              => $bpDate,

                    'unused_voucher'    => true,
                ];

            }
            else
            {
                $historyEntry = [
                    'msg' => 'error',
                    'pending' => true,
                ];
            }
            // deasupra liniei am doar QUERY-uri -  nu se schima nimic
            // aici se modifica chestii -----
            // SIDE-EFFECTS :
            if ($this->isCancelled($historyEntry)) {
                foreach ( $history as $idx => $hEntry )
                {
                    if ( $hEntry['order_id'] == $orderID )
                    {
                        // Avoiding duplicates for cancelled orders
                        unset($history[$idx]);
                    }
                }
            }
            $history []= $historyEntry;
        }
    }

    private function formatDotDate(string $bp_date): string
    {
        $cbpDate = substr($bp_date, 0, 10);
        $cbpDateParts = explode('-', $cbpDate);
        return implode('.', [$cbpDateParts[2], $cbpDateParts[1], $cbpDateParts[0]]);
    }

    private function isCancelled(array $historyEntry): boolean
    {
        return $historyEntry['bonus_points'] == 0 && $historyEntry['pending'] == false;
    }

    /**
     * @param int $customerID
     * @param $today
     * @return array
     * @throws Exception
     */
    private function determineHistoryByOrderId(int $customerID, array $cbpEntry, $today): array // todo HistoryEntry :)
    {
        $orderID            = $cbpEntry['order_id'];
        $voucherCode        = $cbpEntry['voucher_code'];
        $bonusPointsCount   = $cbpEntry['bonus_points'];

        $situation = BonusPointsHelper::getSituationTypeForOrder( $orderID );


        switch ($situation) {
            case BonusPointsHelper::SITUATION_TYPE_NORMAL_ORDER:
                return $this->createHistoryForNormalOrder($orderID, $today, $bonusPointsCount);
            case BonusPointsHelper::SITUATION_TYPE_RETURN_ORDER:

                // TODO: If initial order does not exist in cbpHistory, add it in array and DB as well, for consistency of data
                $parentOrderID = BonusPointsHelper::getParentOrderID($orderID)['parent_order_id'];
                if (!BonusPointsHelper::hasEntryInCBPTable($parentOrderID)) {
                    BonusPointsHelper::resolveCBPTableEntryFor($customerID, $parentOrderID);
                }

                $returnDate = BonusPointsHelper::getOrderDate($orderID);


                $returnDateParts = explode('-', $returnDate);
                $returnDate = implode('.', [$returnDateParts[2], $returnDateParts[1], $returnDateParts[0]]);

                $orderTotal = $this->dbmOrder->getOrderTotalValue($orderID);
                $pending = false;

                if ($orderTotal > 0) {
                    $pending = BonusPointsHelper::isOrderPending($orderID);
                }

               return  [
                    'order_id' => $orderID,
                    'bonus_points' => $bonusPointsCount,
                    'voucherCode' => '',
                    'pending' => $pending,
                    'msg' => $this->translator->_('Returned order'),
                    'date' => $returnDate
                ];
            case BonusPointsHelper::SITUATION_TYPE_BONUS_POINTS_RESTORE:

                $returnDate = BonusPointsHelper::getOrderDate($orderID);
                $initialOrderID = BonusPointsHelper::getParentOrderID($orderID)['parent_order_id'];
                $voucherData = BonusPointsHelper::getBonusPtsAppliedVoucherForOrder($orderID);
                $localVoucherCode = $voucherData['voucher_code'];

                $returnDateParts = explode('-', $returnDate);
                $returnDate = implode('.', [$returnDateParts[2], $returnDateParts[1], $returnDateParts[0]]);

                return [
                    'order_id' => $orderID,
                    'bonus_points' => $bonusPointsCount,
                    'voucher_code' => '',
                    'pending' => false,
                    'msg' => $this->translator->_("Bonus points restore due to using voucher") . " $localVoucherCode " . $this->translator->_("on order") . " #$initialOrderID",
                    'date' => $returnDate
                ];
            case BonusPointsHelper::SITUATION_TYPE_CANCELLED_ORDER:

                $orderDate = BonusPointsHelper::getOrderDate($orderID);

                $orderDateParts = explode('-', $orderDate);
                $orderDate = implode('.', [$orderDateParts[2], $orderDateParts[1], $orderDateParts[0]]);

                // TODO: Remove from CBPEntries the match (initial order)

              return [
                    'order_id' => $orderID,
                    'bonus_points' => 0,
                    'voucher_code' => $voucherCode,
                    'pending' => false,
                    'msg' => $this->translator->_('Cancelled order'),
                    'date' => $orderDate
                ];
            default:
                throw new \Exception('Unexpected value'); // dev friendly pe termen lung
        }
    }

    /**
     * @param $orderID
     * @param $today
     * @param $bonusPointsCount
     * @return array
     */
    private function createHistoryForNormalOrder($orderID, $today, $bonusPointsCount): array
    {
        $pendingBonusPoints = BonusPointsHelper::areBonusPointsPendingForOrder($orderID, $availableFrom, $today);
        $isOrderPending = BonusPointsHelper::isOrderPending($orderID);
        $orderDate = BonusPointsHelper::getOrderDate($orderID);

        $orderDateParts = explode('-', $orderDate);
        $orderDate = implode('.', [$orderDateParts[2], $orderDateParts[1], $orderDateParts[0]]);

        $orderDateParts = explode('-', $availableFrom);
        $availableFrom = implode('.', [$orderDateParts[2], $orderDateParts[1], $orderDateParts[0]]);


        if ($isOrderPending) {
            $msg = $this->translator->_("Order is pending");
        } else {
            $msg = $this->translator->_("Order is delivered") . "<br/>" . ($pendingBonusPoints ?
                    $this->translator->_("Bonus points will be available from") . " $availableFrom" :
                    ""
                );
        }
        return [
            'order_id' => $orderID,
            'bonus_points' => $bonusPointsCount,
            'voucher_code' => '',
            'pending' => $pendingBonusPoints,
            'msg' => $msg,
            'date' => $orderDate
        ];
    }
}

class SituationType {
    const BONUS_POINTS_RESTORE = 1;
}
