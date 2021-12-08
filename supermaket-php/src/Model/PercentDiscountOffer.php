<?php

namespace Supermarket\Model;

class PercentDiscountOffer implements ProductOffer
{
    private readonly Product $product;
    private readonly float $discountPercentage;

    public function __construct(Product $product, float $discountPercentage)
    {
        $this->discountPercentage = $discountPercentage;
        $this->product = $product;
    }

    public function getDiscount(Product $product, float $quantity, float $unitPrice): ?Discount
    {
        return new Discount($product, "{$this->discountPercentage}% off", -$quantity * $unitPrice * $this->discountPercentage / 100.0);
    }
}