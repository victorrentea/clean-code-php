<?php declare(strict_types = 1);

namespace victor\refactoring\videostore;

/**
 * Class Rental
 * Represents a customer's rental of a specific movie.
 */
class Rental
{
    private Movie $movie;
    private int $daysRented;

    /**
     * Rental constructor.
     *
     * @param Movie $movie
     * @param int $daysRented
     */
    public function __construct(Movie $movie, int $daysRented)
    {
        $this->movie = $movie;
        $this->daysRented = $daysRented;
    }

    /**
     * @return int
     */
    public function getDaysRented(): int
    {
        return $this->daysRented;
    }

    /**
     * @param int $daysRented
     */
    public function setDaysRented(int $daysRented): void
    {
        $this->daysRented = $daysRented;
    }

    /**
     * @return Movie
     */
    public function getMovie(): Movie
    {
        return $this->movie;
    }

    /**
     * Calculate the rental charge by delegating to the Movie.
     *
     * @return float
     */
    public function getCharge(): float
    {
        return $this->movie->getCharge($this->daysRented);
    }

    /**
     * Calculate frequent renter points.
     *
     * @return int
     */
    public function getFrequentRenterPoints(): int
    {
        return $this->movie->getFrequentRenterPoints($this->daysRented);
    }
}
