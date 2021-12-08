<?php

namespace Supermarket\Model;

interface ProductOffer
{
    public function getDiscount(Product $product, float $quantity, float $unitPrice): ?Discount;

}