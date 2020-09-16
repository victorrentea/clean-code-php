<?php

namespace victor\refactoring\videostore;

class Rental
{
    private Movie $movie;
    private int $daysRented;

    public function __construct(Movie $movie, int $daysRented)
    {
        $this->movie = $movie;
        $this->daysRented = $daysRented;
    }

    public function getDaysRented(): int
    {
        return $this->daysRented;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function computeRenterPoints(): int
    {
        $frequentRenterPoints = 1;

        if ($this->shouldReceiveBonus()) {
            $frequentRenterPoints++;
        }
        return $frequentRenterPoints;
    }

    private function shouldReceiveBonus(): bool
    {
        return $this->movie->isNewRelease() && $this->daysRented >= 2;
    }
}