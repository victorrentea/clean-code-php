<?php

namespace victor\refactoring\videostore;

readonly class Rental
{

    const REGULAR_DAYS_RENTED_FOR_EXTRA_FEE = 2;

    public function __construct(private Movie $movie, private int $daysRented)
    {
    }

    public function getDaysRented() : int
    {
        return $this->daysRented;
    }

    public function getMovie() : Movie
    {
        return $this->movie;
    }

    public function getRentalAmount(): float
    {
        $daysRented = $this->daysRented;
        return match ($this->movie->getPriceCode()) {
            PriceCode::REGULAR => 2 + max(0, $daysRented - self::REGULAR_DAYS_RENTED_FOR_EXTRA_FEE) * 1.5,
            PriceCode::NEW_RELEASE => $daysRented * 3,
            PriceCode::CHILDREN => 1.5 + max(0, $daysRented - 3) * 1.5,
        };
    }

    public function getFrequentRenterPoints(): int
    {
        return ($this->movie->getPriceCode() == PriceCode::NEW_RELEASE
            && $this->getDaysRented() > 1) ? 2 : 1;
    }
}
