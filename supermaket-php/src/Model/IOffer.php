<?php

namespace Supermarket\Model;

interface IOffer
{
    public function getArgument(): float;

    public function getOfferType(): SpecialOfferType;

    public function getDiscount(Product $product, float $quantity, float $unitPrice): ?Discount;
}