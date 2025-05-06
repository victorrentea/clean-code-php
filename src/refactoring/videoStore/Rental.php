<?php

namespace victor\refactoring\videoStore;

readonly class Rental
{
    public function __construct(private Movie $movie, private int $daysRented)
    {
    }


    public function getDaysRented(): int
    {
        return $this->daysRented;
    }


    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function calculateRentalAmount(): float
    {
        $days = $this->getDaysRented();

        return match ($this->getMovie()->getPriceCode()) {
            PriceCode::REGULAR => 2 + max(0, ($days - 2) * 1.5),
            PriceCode::NEW_RELEASE => $days * 3.0,
            PriceCode::CHILDREN => 1.5 + max(0, ($days - 3) * 1.5),
        };
    }

    public function calculateFrequentRenterPoints(): int
    {
        $points = 1;
        if ($this->movie->getPriceCode() === PriceCode::NEW_RELEASE && $this->daysRented >= 2) {
            $points++;
        }
        return $points;
    }
}
