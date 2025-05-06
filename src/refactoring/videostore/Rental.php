<?php

namespace victor\refactoring\videostore;

readonly class Rental
{
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
}
