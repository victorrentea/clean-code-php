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

    public function computePrice() : float
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
            case Movie::CHILDREN:
                $price += 1.5;
                if ($this->getDaysRented() > 3)
                    $price += ($this->getDaysRented() - 3) * 1.5;
                break;
            default:
                throw new \Exception('Unexpected value ' . $this->movie->getPriceCode());
        }
        return $price;
    }

    public function getFrequentRenterPoints(): int
    {
        $frequentRenterPoints = 1;
        if ($this->getMovie()->isNewRelease() && $this->getDaysRented() >= 2) {
            $frequentRenterPoints++;
        }
        return $frequentRenterPoints;
    }

    // ENTITATILE SUNT CEL MAI SACRU COD DIN APP TA. aici pui doar ce-ai mai sfant.
}
// TODO Movie sa devina clasa abstracta cu 3 subtipuri, una per tip de film
//class RegularMovie extends Movie {
// fiecare implementare in clasa ei