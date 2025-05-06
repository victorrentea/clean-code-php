<?php

namespace victor\refactoring\videoStore;

readonly class Rental
{
    public function __construct(private Movie $movie, private int $daysRented)
    {
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function calculateRentalAmount(): float
    {
        return match ($this->getMovie()->getPriceCode()) {
            PriceCode::REGULAR => 2 + max(0, ($this->daysRented - 2) * 1.5),
            PriceCode::NEW_RELEASE => $this->daysRented * 3.0,
            PriceCode::CHILDREN => 1.5 + max(0, ($this->daysRented - 3) * 1.5),
        };
    }

    public function calculateFrequentRenterPoints(): int
    {
        $points = 1;
        if ($this->movie->isNewRelease() && $this->daysRented >= 2) {
            $points++;
        }
        return $points;

        // return ($this->priceCode === self::NEW_RELEASE && $daysRented > 1) ? 2 : 1;
    }
}


