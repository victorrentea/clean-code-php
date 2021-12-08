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

    private function getDiscount(Offer $offer, float $quantity, float $unitPrice, Product $p): ?Discount
    {
        $discount = null;
        $quantityAsInt = (int)$quantity;

        switch ($offer->getOfferType()) {
            case SpecialOfferType::THREE_FOR_TWO :
            {
                if ($quantityAsInt >= 3) {
                    $discountAmount = $quantity * $unitPrice - (intdiv($quantityAsInt, 3) * 2 * $unitPrice +
                            $quantityAsInt % 3 * $unitPrice);
                    $discount = new Discount($p, '3 for 2', -$discountAmount);
                }
                return $discount;
            }
            case SpecialOfferType::TWO_FOR_AMOUNT:
            {
                if ($quantityAsInt >= 2) {
                    $total = $offer->getArgument() * intdiv($quantityAsInt, 2) + $quantityAsInt % 2 * $unitPrice;
                    $discountN = $unitPrice * $quantity - $total;
                    $discount = new Discount($p, "2 for {$offer->getArgument()}", -1 * $discountN);
                }
                return $discount;
            }
            case SpecialOfferType::FIVE_FOR_AMOUNT:
            {
                if ($quantityAsInt >= 5) {
                    $numberOfXs = intdiv($quantityAsInt, 5);
                    $discountTotal = $unitPrice * $quantity - ($offer->getArgument() * $numberOfXs + $quantityAsInt % 5 * $unitPrice);
                    $discount = new Discount($p, "5 for {$offer->getArgument()}", -$discountTotal);
                }
                return $discount;
            }
            case SpecialOfferType::TEN_PERCENT_DISCOUNT:
            {
                return new Discount($p, "{$offer->getArgument()}% off",
                    -$quantity * $unitPrice * $offer->getArgument() / 100.0
                );
            }
            default:
                throw new \Exception("Unexpected value {$offer->getOfferType()}");

        }
    }
}
