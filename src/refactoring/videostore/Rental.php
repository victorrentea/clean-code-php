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


    /**
     * @return int
     */
    public function getDaysRented()
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

    /**
     * @return Movie
     */
    public function getMovie()
    {
        return $this->movie;
    }

    public function computePrice(): float
    {
        $price = 0;
        switch ($this->getMovie()->getPriceCode()) {
            case Movie::REGULAR:
                $price += 2;
                if ($this->getDaysRented() > 2)
                    $price += ($this->getDaysRented() - 2) * 1.5;
                break;
            case Movie::NEW_RELEASE:
                $price += $this->getDaysRented() * 3;
                break;
            case Movie::CHILDRENS:
                $price += 1.5;
                if ($this->getDaysRented() > 3) {
                    $price += ($this->getDaysRented() - 3) * 1.5;
                }
                break;
        }
        return $price;
    }

    public function addFrequentRenterPoints(): int
    {
        $frequentRenterPoints = 1;

        // add bonus for a two day new release rental
        if ($this->getMovie()->getPriceCode() == Movie::NEW_RELEASE
            && $this->getDaysRented() > 1)
            $frequentRenterPoints++;
        return $frequentRenterPoints;
    }


}