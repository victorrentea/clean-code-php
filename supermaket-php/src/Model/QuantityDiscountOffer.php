<?php

namespace Supermarket\Model;

use JetBrains\PhpStorm\Pure;

class QuantityDiscountOffer implements ProductOffer
{
    private readonly int $quantity;
    private readonly float $price;

    public function __construct(int $offerQuantity, float $price)
    {
        $this->quantity = $offerQuantity;
        $this->price = $price;
    }

    #[Pure] public function getDiscount(Product $product, float $quantity, float $unitPrice): ?Discount
    {
        $quantityAsInt = (int)$quantity;
        $discount = null;
        if ($quantityAsInt >= $this->quantity) {
            $discount = $unitPrice * $quantity - ($this->price * intdiv($quantityAsInt, $this->quantity) + $quantityAsInt % $this->quantity * $unitPrice);
            $discount = new Discount($product, "$this->quantity for {$this->price}", -$discount);
        }
        return $discount;
    }
}