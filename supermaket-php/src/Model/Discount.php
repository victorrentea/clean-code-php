<?php

declare(strict_types=1);

namespace Supermarket\Model;

class Discount
{
    private Product $product;

    private string $description;

    private float $discount;

    public function __construct(Product $product, string $description, float $discount)
    {
        $this->product = $product;
        $this->description = $description;
        $this->discount = $discount;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDiscountAmount(): float
    {
        return $this->discount;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
