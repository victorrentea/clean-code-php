<?php

namespace Avanticart\Service;
use Avanticart\Service\EventManager;

class ExplodeCompositeOrder
{
    public function explode ($orderID)
    {
        $dbmProduct     =   new \Dbm_Product();
        $dbmProductPrice = new \Dbm_ProductPrice();
        $dbmCustomer    =   new \Dbm_Customer();
        $dbmOrder = new \Dbm_Order();

        $orderCart = new \OrderCart($orderID, \Dispatcher::$serviceContainer);
        $orderCart->setUseExplicitProductsPricesCustomerGroup(true);

        $cart  =   new \CartContainer( $orderCart , ['freeze_shipping_cost' => 1]);

        $customer = $cart->getCustomer();
        $customerId =  $customer->customer->customer_id;

        $customerGroupId = $dbmCustomer->getCustomerGroupById($customerId);

        $orderTotal = $dbmOrder->findFirstSimple(['order_id' => $orderID]);
        $orderTotal = (float)$orderTotal['order_total'];

        $compositeProducts = false;

        try {
            $dbmOrder->begin ();
            $products = $cart->getProducts (true);
            foreach ( $products as $product )
            {
                $productID = $product->get('product_id');
                $taxId = $product->getTaxId();

                if ( !$dbmOrder->productIsComposite ($productID) ) {
                    continue;
                }

                $compositeProducts = true;
                $options = $product->getOptions();

                $productQty = (float)$product->getQuantity();
                $voucher = null;
                $voucherFields = [];

                $voucherItems = $orderCart->itemsContainer->getItems(\CartItem::ITEM_TYPE_VOUCHER);
                foreach ($voucherItems as $voucherItem)
                {
                    if ($voucherItem->getRelatedId() == $productID)
                    {
                        $voucher = $voucherItem;
                        $orderCart->itemsContainer->removeItem($voucherItem->getKey());
                        break;
                    }
                }

                // OTD
                $otd = null;
                $otdFields = [];

                $otdItems = $orderCart->itemsContainer->getItems(\CartItem::ITEM_TYPE_TOTAL_DISCOUNT);
                foreach ($otdItems as $otdItem)
                {
                    if ($otdItem->getRelatedId() == $productID)
                    {
                        $otd = $otdItem;
                        $orderCart->itemsContainer->removeItem($otdItem->getKey());
                        break;
                    }
                }
                $orderCart->itemsContainer->removeItem($product->getKey());

                $compositeSelection = $product->getCompositeSelection();

                if (
                    defined('FIX_COMPOSITE_SELECTION_IN_EXPLODE_ORDER')
                    && FIX_COMPOSITE_SELECTION_IN_EXPLODE_ORDER
                )
                {
                    foreach ($compositeSelection as &$cp)
                    {
                        if ($dbmProduct->isParent($cp['value_id']))
                        {
                            $children = $dbmProduct->getChildrenIds($cp['value_id']);
                            foreach ($children as $key => $childID)
                            {
                                if ((float)$dbmProductPrice->getProductPrice($childID) > 0)
                                {
                                    continue;
                                }
                                unset($children[$key]);
                            }
                            if (count($children) == 1)
                            {
                                $cp['value_id'] = array_shift($children);
                            }
                        }
                    }
                }

                $comments = $product->getComments();
                $op = $dbmOrder->findFirstSimple(['order_id' => $orderID, 'product_package' => $product->getPackageKey(), 'product_id' => $productID], null, ['dataset' => 'order_products']);
                if (empty($op))
                {
                    $op = $dbmOrder->findFirstSimple(['order_id' => $orderID, 'product_id' => $productID], null, ['dataset' => 'order_products']);

                }
                $fields = ['order_id' => $orderID,
                         'product_package' => $product->getPackageKey(),
                         'product_id' => $productID,
                         'product_price' => $op['product_price'],
                         'product_net_price' => $op['product_net_price'],
                         'product_quantity' => $product->getQuantity(),
                         'options' => serialize($options),
                         'composite_selection' => serialize($compositeSelection),
                         'comments' => $comments];

                // get voucher
                if ($voucher)
                {
                    $voucherFields = ['order_id' => $orderID,
                                        'product_package' => $product->getPackageKey(),
                                        'product_price' => $voucher->getPrice(),
                                        'product_net_price' => $voucher->getNetPrice(),
                                        'product_quantity' => $voucher->getQuantity(),
                                        'shop_module_class' => 'Voucher'];

                }

                if ($otd)
                {
                    $otdFields = ['order_id' => $orderID,
                                    'product_package' => $product->getPackageKey(),
                                    'product_price' => $otd->getPrice(),
                                    'product_net_price' => $otd->getNetPrice(),
                                    'product_quantity' => $otd->getQuantity(),
                                    'shop_module_class' => \CartItem::ITEM_TYPE_TOTAL_DISCOUNT];
                }

                if ($dbmOrder->tableExists('order_package_price'))
                {
                    $dbmOrder->delete(['order_id' => $orderID, 'product_package' => $product->getPackageKey()], ['dataset' => 'order_package_price']);

                    $dbmOrder->insert($fields, null, ['dataset' => 'order_package_price', \Dbm_Model::OPT_ON_DUPLICATE_UPDATE => $fields]);
                    if ($voucherFields)
                    {
                        $dbmOrder->insert($voucherFields, null, ['dataset' => 'order_package_price', \Dbm_Model::OPT_ON_DUPLICATE_UPDATE => $voucherFields]);
                    }
                    if ($otdFields)
                    {
                        $dbmOrder->insert($otdFields, null, ['dataset' => 'order_package_price', \Dbm_Model::OPT_ON_DUPLICATE_UPDATE => $otdFields]);
                    }
                }

                $components = $dbmProduct->getComponentsOrderedByPrice ($productID);
                $product_name = $dbmProduct->getProductName ($productID);

                $comment = '<a href="index.php5?module=ProductManagement&action=productEdit&product_id=' . $productID . '">' . $product_name . '</a>\'s  components !';
                $comment .= "\n";
                $comment .= "<table border='1' class='order-table'>";
                $comment .= "<tr><th>Qty</th>";
                $comment .= "<th>Sku</th>";
                $comment .= "<th>Product Name</th>";
                $comment .= "</tr>";

                /* @var $cache Cw_Memcache */
                $cache = \Cache::getInstance();

                foreach ( $components as $c )
                {
                    $cID = $dbmOrder->getCompositeSelectionProductId($c['sub_product_id'], $compositeSelection, $c['is_extra']);
                    if (!$cID)
                    {
                        continue;
                    }
                    $multiplier = $c[ 'quantity' ];
                    $cQty = $productQty * $multiplier;
                    $productItem = new \CartItemProduct($cID, $cQty, $cart->CartModel, $productID, $product->getPackageKey(), $c['is_extra'], $customerGroupId);
                    $productItem->setRelatedId($productID);
                    $productItem->setTaxId($taxId);
                    if (!empty($options))
                    {
                        $productItem->addOptions($options);
                        unset($options);
                    }

                    if (!empty($comments))
                    {
                        $productItem->saveComments($comments);
                        unset($comments);
                    }
                    $cart->add ($productItem, $cQty, false, $customerGroupId);

                    $cPrice = $dbmProductPrice->getProductPrice($cID, $customerGroupId);

                    $product_name = $dbmProduct->getProductName ($c[ 'sub_product_id' ]);
                    $product_sku = $dbmProduct->getProductSKU ($cID);
                    $comment .= '<tr><td>' . $multiplier . '</td><td>' . $product_sku . '</td><td>
                <a href="index.php5?module=ProductManagement&action=productEdit&product_id=' . $c[ 'sub_product_id' ] . '">' . $product_name . '</a></td></tr>';
                    $cache->deleteProductCacheOnStockUpdate($cID);
                }
                $comment .= "</table>";

                $dbmOrder->addComment ($orderID, $comment, 'ExplodeCompositeOrder', "system");

                //ALL THE VOUCHER STUFF IS NOT NEEDED. IT IS AUTOMATICALLY DONE IN VoucherForPackage order total module
            }

            if (!$compositeProducts)
            {
                return;
            }

            $cart->update ();

            $orderTotal2 = (float)$cart->getTotalValue (\OrderTotal::OT_TOTAL_CLASS);

            if (defined("EXPLODE_ORDER_MAX_TOTAL_DIFF") && (float)EXPLODE_ORDER_MAX_TOTAL_DIFF)
            {
                $maxDiff = EXPLODE_ORDER_MAX_TOTAL_DIFF;
            }
            else
            {
                $maxDiff = 0.1;
            }
            
            if (
                (abs($orderTotal - $orderTotal2) < $maxDiff)
                || isset($_GET['force-explode'])
            )
            {
                //delete all old order products and insert new ones
                $dbmOrder->delete(['order_id' => $orderID], ['dataset' => 'order_products']);
                $dbmOrder->saveCartItems ($orderID, $cart->CartModel);
            }
            else
            {
                $dbmOrder->addComment ($orderID, 'Tehnical problems', 'ExplodeCompositeOrder', "system");

                if (defined('TECHNICAL_ERROR_ORDER_STATUS_ID') && TECHNICAL_ERROR_ORDER_STATUS_ID)
                {
                    $dbmOrder->setOrderStatus($orderID, TECHNICAL_ERROR_ORDER_STATUS_ID, null, false);
                }

                $emailText = [];
                $emailText[] = 'Order #' . $orderID;
                foreach ($cart->getItems() as $item)
                {
                    $emailText[] = $item->getName() . ' ' . $item->getPrice() . ' x ' . $item->getQuantity();
                }
                $emailText[] = 'Old total = ' . $orderTotal;
                $emailText[] = 'New total = ' . $orderTotal2;

                // var_dump($emailText);die;

                $email = new \Email( new \Template(new \Dispatcher()) );

                $email->setFrom(\Constdef::getInstance()->getConstantForStore('_CONTACT_EMAIL', $dbmOrder->getStoreByOrderId($orderID)));
                $email->setSubject(ucfirst(_INTERNAL_SHOP_NAME) . ' - ExplodeCompositeOrder');
                $email->setTextBody(implode("\n", $emailText));

                $email->setTo('alex@avanticart.ro');
                $emails_ids = $email->queue(true);
            }

            // var_dump($cart);die;

//TODO update la cart total, sau salvare total_amount
            //
            // $newOrderTotal = $cart->getTotalValue (OrderTotal::OT_TOTAL_CLASS);
            // if (abs($newOrderTotal-$orderTotal) > 0.01) {
            //     $newVoucherTotal = -1 * ( $newOrderTotal - $orderTotal ) + $voucherTotal;
            //     $cart->setTotalProperty (OrderTotal::OT_VOUCHER_CLASS, 'voucher_value', $newVoucherTotal);
            //     $cart->setTotalProperty (OrderTotal::OT_VOUCHER_CLASS, 'order_total_value', $newVoucherTotal);
            //     $cart->setTotalProperty (OrderTotal::OT_VOUCHER_CLASS, 'voucher_is_percentage', 0);
            //     $cart->setTotalProperty (OrderTotal::OT_VOUCHER_CLASS, 'voucher_code', '');
            // }
//             $cart->update();


            $dbmOrder->commit();

            try
            {
                //zend framework type eventmanager notify
                $parametersForEventManger = ['source'=>'Created_Order_withExplodedProduct','order_id' => $orderID];
                $em = new EventManager\OrdersEvents();
                $em->orderChanged($parametersForEventManger);
            }
            catch (\Exception $e)
            {

            }

        } catch (\Exception $e) {
            $dbmOrder->rollback ();
            $dbmOrder->log ('Error bisecting order ' . $e->getMessage());
            echo $e->getMessage();
            die( 'dead' );
        }

        return 0;
    }

}

