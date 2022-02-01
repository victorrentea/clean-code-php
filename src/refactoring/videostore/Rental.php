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
        switch ($this->getMovie()->getPriceCode()) {
            case Movie::REGULAR: return $this->computeRegularPrice();
            case Movie::NEW_RELEASE: return $this->computeNewReleasePrice();
            case Movie::CHILDREN: return $this->computeChildrenPrice();
            default:
                throw new \Exception('Unexpected value ' . $this->movie->getPriceCode());
        }
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

    private function computeRegularPrice(): float
    {
        $price = 2;
        if ($this->getDaysRented() > 2)
            $price += ($this->getDaysRented() - 2) * 1.5;
        return $price;
    }

    const DOAMNE_IARTA  = [];





    private function computeNewReleasePrice(): float
    {

        // self::DOAMNE_IARTA[Movie::REGULAR]= fn(int $s) => $s + 1; // evita

        return $this->getDaysRented() * 3;
    }

    private function computeChildrenPrice(): float
    {
        $price = 1.5;
        if ($this->getDaysRented() > 3) {
            $price += ($this->getDaysRented() - 3) * 1.5; // PRICE_FACTOR_FOR_LONGER_RENTALS_FOR_CHILDREN
        }
        return $price;
    }
}
// TODO Movie sa devina clasa abstracta cu 3 subtipuri, una per tip de film
//class RegularMovie extends Movie {
// fiecare implementare in clasa ei


// cand ati face 100% sigur subclase pentru tipuri de filme
// - pentru categorii de filme (drama, comedie) -ceva nemodificabil in timp
// - [subiectiv, pararea lui Victor] eu evit sa fac subclase doar cand se schimba behaviorul intre ele.
// EU MEREU creez subtipuri DACA SI NUMAI DACA AU ATRIBUTE IN PLUS FATA TE SUPERTIP


$answerDetails = [];
$x = isset($answerDetails[DBConstantts::CATEGORY_ID_FIELD]) ? $answerDetails[DBConstantts::CATEGORY_ID_FIELD] : 0;

class DBConstantts {

    const CATEGORY_ID_FIELD = "a";
}