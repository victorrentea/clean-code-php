<?php

namespace Supermarket\Model\offer;

use JetBrains\PhpStorm\Pure;
use Supermarket\Model\Discount;
use Supermarket\Model\Product;

class QuantityDiscountOffer implements ProductOffer
{
    private readonly Product $product;
    private readonly int $quantity;
    private readonly float $price;

    public function __construct(Product $product, int $offerQuantity, float $price)
    {
        $this->quantity = $offerQuantity;
        $this->price = $price;
        $this->product = $product;
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