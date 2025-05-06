<?php

namespace victor\refactoring\videostore;

class Rental
{
    /**
     * Rental constructor.
     * @param Movie $movie
     * @param int $daysRented
     */
    public function __construct(private readonly Movie $movie, private int $daysRented)
    {
    }

    /**
     * @return int
     */
    public function getDaysRented() : int
    {
        return $this->daysRented;
    }

    /**
     * @param int $daysRented
     */
    public function setDaysRented(int $daysRented) : void
    {
        $this->daysRented = $daysRented;
    }

    /**
     * @return Movie
     */
    public function getMovie() : Movie
    {
        return $this->movie;
    }
}
