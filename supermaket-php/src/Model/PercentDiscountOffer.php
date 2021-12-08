<?php

namespace Supermarket\Model;

class PercentDiscountOffer implements ProductOffer
{

    private readonly float $discountPercentage;

    public function __construct(float $discountPercentage)
    {
        $this->discountPercentage = $discountPercentage;
    }

    public function getDiscount(Product $product, float $quantity, float $unitPrice): ?Discount
    {
        return new Discount($product, "{$this->discountPercentage}% off", -$quantity * $unitPrice * $this->discountPercentage / 100.0);
    }
}