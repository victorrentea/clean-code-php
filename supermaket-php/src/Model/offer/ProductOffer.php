<?php

namespace Supermarket\Model\offer;

use Supermarket\Model\Discount;
use Supermarket\Model\Product;

interface ProductOffer
{
    public function getDiscount(Product $product, float $quantity, float $unitPrice): ?Discount;
    public function getProduct(): Product;
}