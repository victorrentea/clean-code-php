<?php

namespace victor\refactoring\videostore;

readonly class Rental
{

    const MAX_RENTAL_REGULAR = 2;
    const MAX_RENTAL_CHILDREN = 3;

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
        $daysRented = $this->getDaysRented();
        return match ($this->getMovie()->getPriceCode()) {
            PriceCode::REGULAR => 2 + max(0, $daysRented - self::MAX_RENTAL_REGULAR) * 1.5,
            PriceCode::NEW_RELEASE => $daysRented * 3,
            PriceCode::CHILDREN => 1.5 + max(0, $daysRented - self::MAX_RENTAL_CHILDREN) * 1.5,
        };
    }

    public function getFrequentRenterPoints(): int
    {
        return ($this->getMovie()->getPriceCode() == PriceCode::NEW_RELEASE
            && $this->getDaysRented() > 1) ? 2 : 1;
    }
}
