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

    /**
     * @var Map [Product => quantity]
     */
    private $productQuantities;

    public function __construct()
    {
        $this->productQuantities = new Map();
    }

    public function addItem(Product $product): void
    {
        $this->addItemQuantity($product, 1.0);
    }

    public function addItemQuantity(Product $product, float $quantity): void
    {
        $this->items[] = new ProductQuantity($product, $quantity);
        if ($this->productQuantities->hasKey($product)) {
            $newAmount = $this->productQuantities[$product] + $quantity;
            $this->productQuantities[$product] = $newAmount;
        } else {
            $this->productQuantities[$product] = $quantity;
        }
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
         * @var Product $p
         * @var float $quantity
         */
        foreach ($this->productQuantities as $p => $quantity) {
            $quantityAsInt = (int)$quantity;
            if ($offers->hasKey($p)) {
                /** @var Offer $offer */
                $offer = $offers[$p];
                $unitPrice = $catalog->getUnitPrice($p);

                $discount = $this->getDiscount($offer, $quantity, $unitPrice, $p);

                if ($discount !== null) {
                    $receipt->addDiscount($discount);
                }
            }
        }
    }

    private function getDiscount(Offer $offer, float $quantity, float $unitPrice, Product $product): ?Discount
    {
        return match ($offer->getOfferType()) {
            SpecialOfferType::THREE_FOR_TWO  => $this->createThreeForTwoDiscount($product, $quantity, $unitPrice),
            SpecialOfferType::TWO_FOR_AMOUNT => $this->createTwoForAmountDiscount($product, $quantity, $unitPrice, $offer),
            SpecialOfferType::FIVE_FOR_AMOUNT => $this->createFiveForAmountDiscount($product, $quantity, $unitPrice, $offer),
            SpecialOfferType::TEN_PERCENT_DISCOUNT => $this->createTenPerecentDiscount($product, $quantity, $unitPrice, $offer),
        };
    }

    private function createThreeForTwoDiscount(Product $product, float $quantity, float $unitPrice): ?Discount
    {
        $quantityAsInt = (int)$quantity;
        $discount= null;
        if ($quantityAsInt >= 3) {
            $discountAmount = $quantity * $unitPrice - (intdiv($quantityAsInt, 3) * 2 * $unitPrice +
                    $quantityAsInt % 3 * $unitPrice);
            $discount = new Discount($product, '3 for 2', -$discountAmount);
        }
        return $discount;
    }

    private function createTwoForAmountDiscount(Product $product, float $quantity, float $unitPrice, Offer $offer): ?Discount
    {
        $quantityAsInt = (int)$quantity;
        $discount = null;
        if ($quantityAsInt >= 2) {
            $total = $offer->getArgument() * intdiv($quantityAsInt, 2) + $quantityAsInt % 2 * $unitPrice;
            $discountN = $unitPrice * $quantity - $total;
            $discount = new Discount($product, "2 for {$offer->getArgument()}", -1 * $discountN);
        }
        return $discount;
    }

    private function createFiveForAmountDiscount(Product $product, float $quantity, float $unitPrice, Offer $offer): ?Discount
    {
        $quantityAsInt = (int)$quantity;
        $discount = null;
        if ($quantityAsInt >= 5) {
            $numberOfXs = intdiv($quantityAsInt, 5);
            $discountTotal = $unitPrice * $quantity - ($offer->getArgument() * $numberOfXs + $quantityAsInt % 5 * $unitPrice);
            $discount = new Discount($product, "5 for {$offer->getArgument()}", -$discountTotal);
        }
        return $discount;
    }

    private function createTenPerecentDiscount(Product $product, float $quantity, float $unitPrice, Offer $offer): ?Discount
    {
        return new Discount($product, "{$offer->getArgument()}% off",
            -$quantity * $unitPrice * $offer->getArgument() / 100.0
        );
    }
}
