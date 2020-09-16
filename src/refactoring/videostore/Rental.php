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
            $frequentRenterPoints++; // "ii mai da un punct" zicea specul
        }
        return $frequentRenterPoints;
    }
//    public function computeRenterPointsTernar(): int
//    {
//        return $this->shouldReceiveBonus() ? 2 : 1;
//    }

    private function shouldReceiveBonus(): bool
    {
        return $this->movie->isNewRelease() && $this->daysRented >= 2;
    }

    public function computePrice(): float
    {
//        return $this->movie->computePrice($this->daysRented);
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

class B
{

    public function getName(): ?string
    {
        return "X";
    }
}

class A
{
    public function b(): ?B
    {
        return null;
    }
}

$a = new A();
//var_dump($a->b()->getName() ?? "");

//var_dump($a->b() ? $a->b()->getName() : "");
//if ($a->b() &&
//    $a->b()->c() &&
//    $a->b()->c()->d()
//)    {
//    var_dump($a->b()->c()->d());
//}