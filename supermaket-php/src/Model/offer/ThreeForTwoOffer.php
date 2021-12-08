<?php

namespace Supermarket\Model\offer;

use Supermarket\Model\Discount;
use Supermarket\Model\Product;

class ThreeForTwoOffer implements ProductOffer
{

    private readonly Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getDiscount(Product $product, float $quantity, float $unitPrice): ?Discount
    {
        $quantityAsInt = (int)$quantity;
        if ($quantityAsInt < 3) {
            return null;
        }
        $discountedAmount = $unitPrice * intdiv($quantityAsInt, 3);
        return new Discount($product, '3 for 2', -$discountedAmount);
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}