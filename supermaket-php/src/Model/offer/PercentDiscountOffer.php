<?php

namespace Supermarket\Model\offer;

use Supermarket\Model\Discount;
use Supermarket\Model\Product;

class PercentDiscountOffer implements ProductOffer
{
    private readonly Product $product; // TODO de expus cu getter din interfata
    private readonly float $discountPercentage;

    public function getProduct(): Product
    {
        return $this->product;
    }
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