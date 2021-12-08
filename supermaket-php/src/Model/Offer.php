<?php

declare(strict_types=1);

namespace Supermarket\Model;

class Offer implements IOffer
{
    private Product $product; // TODO possible bug

    private SpecialOfferType $offerType;

    private float $argument;

    public function __construct(SpecialOfferType $offerType, Product $product, float $argument)
    {
        $this->offerType = $offerType;
        $this->product = $product;
        $this->argument = $argument;
    }

    public function getArgument(): float
    {
        return $this->argument;
    }

    public function getOfferType(): SpecialOfferType
    {
        return $this->offerType;
    }

    public function getDiscount(Product $product, float $quantity, float $unitPrice): ?Discount
    {
        return match ($this->getOfferType()) {
            SpecialOfferType::THREE_FOR_TWO => $this->createThreeForTwoDiscount($product, $quantity, $unitPrice),
            SpecialOfferType::TWO_FOR_AMOUNT => $this->createDiscountForQuantity(2, $product, $quantity, $unitPrice),
            SpecialOfferType::FIVE_FOR_AMOUNT => $this->createDiscountForQuantity(5, $product, $quantity, $unitPrice),
            SpecialOfferType::TEN_PERCENT_DISCOUNT => $this->createTenPercentDiscount($product, $quantity, $unitPrice),
        };
    }

    private function createThreeForTwoDiscount(Product $product, float $quantity, float $unitPrice): ?Discount
    {
        $quantityAsInt = (int)$quantity;
        if ($quantityAsInt < 3) {
            return null;
        }
        $discountedAmount = $unitPrice * intdiv($quantityAsInt, 3);
        return new Discount($product, '3 for 2', -$discountedAmount);
    }

    private function createTenPercentDiscount(Product $product, float $quantity, float $unitPrice): ?Discount
    {
        return new Discount($product, "{$this->getArgument()}% off",
            -$quantity * $unitPrice * $this->getArgument() / 100.0
        );
    }

    private function createDiscountForQuantity(int $offerQuantity, Product $product, float $quantity, float $unitPrice): ?Discount
    {
        $quantityAsInt = (int)$quantity;
        $discount = null;
        if ($quantityAsInt >= $offerQuantity) {
            $discount = $unitPrice * $quantity - ($this->getArgument() * intdiv($quantityAsInt, $offerQuantity) + $quantityAsInt % $offerQuantity * $unitPrice);
            $discount = new Discount($product, "$offerQuantity for {$this->getArgument()}", -$discount);
        }
        return $discount;
    }
}
