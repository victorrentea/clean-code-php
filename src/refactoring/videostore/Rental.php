<?php declare(strict_types = 1);

namespace victor\refactoring\videostore;
class Rental
{
    /**
     * @var Movie
     */
    private Movie $movie;
    private int $daysRented;

    /**
     * Rental constructor.
     * @param Movie $movie
     * @param $daysRented
     */
    public function __construct(Movie $movie, $daysRented)
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
     * @return void
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
}
