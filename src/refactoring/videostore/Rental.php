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

    public function determineAmountsForLine(): float
    {
        $thisAmount = 0;
        switch ($this->movie->getType()) {
            case Movie::TYPE_REGULAR:
                $thisAmount += 2;
                if ($this->daysRented > 2) {
                    $thisAmount += ($this->daysRented - 2) * 1.5;
                }
                break;
            case Movie::TYPE_NEW_RELEASE:
                $thisAmount += $this->daysRented * 3;
                break;
            case Movie::TYPE_CHILDREN:
                $thisAmount += 1.5;
                if ($this->daysRented > 3) {
                    $thisAmount += ($this->daysRented - 3) * 1.5;
                }
                break;
            default:
                throw new \Exception('Unexpected value ' . $this->movie->getType());
        }
        return $thisAmount;
    }
}