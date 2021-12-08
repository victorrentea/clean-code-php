<?php

declare(strict_types=1);

namespace Supermarket\Model;

class ReceiptItem
{
    private Product $product;

    private readonly float $quantity;

    private readonly float $unitPrice;

    private readonly float $totalPrice;

    public function __construct(Product $product, float $quantity, float $price, float $totalPrice)
    {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->unitPrice = $price;
        $this->totalPrice = $totalPrice;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }
}
