<?php

declare(strict_types=1);

namespace Supermarket\Model;

use Ds\Map;

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
        $this->items[] = new ProductQuantity($product, $quantity);  // 1
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
    public function handleOffers(Receipt $receipt, Map $offers, SupermarketCatalog $catalog): void
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
            /** @var Offer $offer */
            $offer = $offers[$product];
            $unitPrice = $catalog->getUnitPrice($product);

            $discount = $this->getDiscount($offer, $quantity, $unitPrice, $product);

            if ($discount !== null) {
                $receipt->addDiscount($discount);
            }
        }
    }

    private function getDiscount(Offer $offer, float $quantity, float $unitPrice, Product $product): ?Discount
    {
        return match ($offer->getOfferType()) {
            SpecialOfferType::THREE_FOR_TWO => $this->createThreeForTwoDiscount($product, $quantity, $unitPrice),
            SpecialOfferType::TWO_FOR_AMOUNT => $this->createDiscountForQuantity(2, $product, $quantity, $unitPrice, $offer),
            SpecialOfferType::FIVE_FOR_AMOUNT => $this->createDiscountForQuantity(5, $product, $quantity, $unitPrice, $offer),
            SpecialOfferType::TEN_PERCENT_DISCOUNT => $this->createTenPerecentDiscount($product, $quantity, $unitPrice, $offer),
        };
    }

    private function createThreeForTwoDiscount(Product $product, float $quantity, float $unitPrice): ?Discount
    {
        $quantityAsInt = (int)$quantity;
        if ($quantityAsInt < 3) {
            return null;
        }
        // $extraItemsNotInOffer = $quantityAsInt % 3;
        // $discountedQuantity = intdiv($quantityAsInt, 3) * 2 + $extraItemsNotInOffer;
        // $finalQuantity = $quantity - $discountedQuantity;
        // $discountAmount = $unitPrice * ($finalQuantity);
        $discountedAmount = $unitPrice * intdiv($quantityAsInt, 3);
        return new Discount($product, '3 for 2', -$discountedAmount);
    }

    private function createTenPerecentDiscount(Product $product, float $quantity, float $unitPrice, Offer $offer): ?Discount
    {
        return new Discount($product, "{$offer->getArgument()}% off",
            -$quantity * $unitPrice * $offer->getArgument() / 100.0
        );
    }

    /**
     * @return Map
     */
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

    private function createDiscountForQuantity(int $offerQuantity, Product $product, float $quantity, float $unitPrice, Offer $offer): ?Discount
    {
        $quantityAsInt = (int)$quantity;
        $discount = null;
        if ($quantityAsInt >= $offerQuantity) {
            $discount = $unitPrice * $quantity - ($offer->getArgument() * intdiv($quantityAsInt, $offerQuantity) + $quantityAsInt % $offerQuantity * $unitPrice);
            $discount = new Discount($product, "$offerQuantity for {$offer->getArgument()}", -$discount);
        }
        return $discount;
    }
}
