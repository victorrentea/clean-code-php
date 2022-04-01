<?php
namespace victor\refactoring\videostore;

class Rental
{
    /**
     * @var Movie
     */
    private $movie;
    private $daysRented;

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


    public function getDaysRented(): int
    {
        return $this->daysRented;
    }

    /**
     * @param int $daysRented
     */
    public function setDaysRented($daysRented)
    {
        $this->daysRented = $daysRented;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }




}