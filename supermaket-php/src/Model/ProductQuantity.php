<?php

declare(strict_types=1);

namespace Supermarket\Model;

class ProductQuantity
{
    private readonly Product $product;

    private readonly float $quantity;

    public function __construct(Product $product, float $weight)
    {
        $this->product = $product;
        $this->quantity = $weight;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }
}
