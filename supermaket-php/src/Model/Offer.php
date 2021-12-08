<?php

namespace Supermarket\Model;

interface Offer
{
    public function getDiscount(Product $product, float $quantity, float $unitPrice): ?Discount;
}