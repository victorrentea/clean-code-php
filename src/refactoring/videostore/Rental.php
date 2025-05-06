<?php
namespace victor\refactoring\videostore;

readonly class Rental
{
    public function __construct(
        private Movie $movie,
        private int $daysRented
    ) {
    }


    public function getDaysRented(): int
    {
        return $this->daysRented;
    }


    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function getRentalAmount(): float
    {
        $daysRented = $this->getDaysRented();
        return match ($this->getMovie()->getPriceCode()) {
            PriceCodeEnum::REGULAR => 2 + ($daysRented > 2)
                ? $daysRented - 2 * 1.5
                : $daysRented,
            PriceCodeEnum::NEW_RELEASE => $daysRented * 3,
            PriceCodeEnum::CHILDREN => 1.5 + ($daysRented > 3)
                ? $daysRented - 3 * 1.5
                : $daysRented,
        };
    }
}