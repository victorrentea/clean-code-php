<?php


namespace victor\refactoring;


class ExtractInlineVariable
{
    function f() {
        $order = new Order();
        $order->computePrice();
    }

    //  TODO: touch on split variable
}

class Order {
    const MAX_TAX = 100;
    const VOLUME_DISCOUNT_QUANTITY_LIMIT = 500;
    public int $quantity;
    public int $itemPrice;
    public int $basePrice; // stochezi calcule pe campuri.
    // NICIODATA nu stochezi calcule intermediare in entitati sau in alte clase cu date

    private function basePrice(): float
    {
        return $this->quantity * $this->itemPrice;
    }

    public function computePrice(): float
    {
        return $this->basePrice() - $this->computeVolumeDiscount() + $this->computeTax();
    }

    private function computeVolumeDiscount(): float
    {
        $volumeDiscount = 0;
        if ($this->quantity > self::VOLUME_DISCOUNT_QUANTITY_LIMIT) {
            $volumeDiscount = ($this->quantity - self::VOLUME_DISCOUNT_QUANTITY_LIMIT) * $this->itemPrice * 0.05;
        }
        return $volumeDiscount;
    }

    private function computeTax(): float
    {
        $tax = $this->basePrice() * 0.1;
        if ($tax > self::MAX_TAX) {
            $tax = self::MAX_TAX;
        }
        return $tax;
    }


}