<?php declare(strict_types = 1);

namespace victor\refactoring\videostore;

use victor\refactoring\videostore\Constants;
class Movie
{
    private string $title;
    private string $priceCode;

    public function __construct(string $title, string $priceCode)
    {
        $this->title = $title;
        $this->priceCode = $priceCode;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCharge(int $daysRented): float
    {
        return match ($this->priceCode) {
            Constants::REGULAR => 2 + max(0, $daysRented - 2) * 1.5,
            Constants::NEW_RELEASE => $daysRented * 3.0,
            Constants::CHILDRENS => 1.5 + max(0, $daysRented - 3) * 1.5,
            default => throw new \InvalidArgumentException("Invalid price code: {$this->priceCode}"),
        };
    }

    public function getFrequentRenterPoints(int $daysRented): int
    {
        return ($this->priceCode === Constants::NEW_RELEASE && $daysRented > 1) ? 2 : 1;
    }
}
