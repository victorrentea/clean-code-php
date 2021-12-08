<?php

declare(strict_types=1);

namespace Supermarket\Model;

use Ds\Map;
use function Symfony\Component\String\u;

class ShoppingCart
{
    /**
     * @var ProductQuantity[]
     */
    private $items = [];

    public function addItem(Product $product): void
    {
        $this->addItemQuantity($product, 1.0);
    }

    public function addItemQuantity(Product $product, float $quantity): void
    {
        $this->items[] = new ProductQuantity($product, $quantity);
    }

    /**
     * @return ProductQuantity[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Map $offers [Product => Offer]
     */
    public function handleProductOffers(Receipt $receipt, Map $offers, SupermarketCatalog $catalog): void
    {
        /**
         * @var Product $product
         * @var float $quantity
         */
        $productQuantities = $this->consolidateQuantities();

        foreach ($productQuantities as $product => $quantity) { // 3
            if (!$offers->hasKey($product)) {
                continue;
            }
            /** @var ProductOffer $offer */
            $offer = $offers[$product];
            $unitPrice = $catalog->getUnitPrice($product);

            $discount = $offer->getDiscount($product, $quantity, $unitPrice);

            if ($discount !== null) {
                $receipt->addDiscount($discount);
            }
        }
    }

    private function consolidateQuantities(): Map
    {
        $productQuantities = new Map();
        foreach ($this->items as $item) {
            if (!$productQuantities->hasKey($item->getProduct())) {
                $productQuantities[$item->getProduct()] = 0;
            }
            $productQuantities[$item->getProduct()] += $item->getQuantity(); // 2
        }
        return $productQuantities;
    }
}
