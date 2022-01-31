<?php

namespace victor\refactoring\videostore;

class Customer
{
    private string $name;
    /**
     * @var Rental[]
     */
    private array $rentals = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addRental(Rental $rental)
    {
        $this->rentals[] = $rental;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function generateStatement(): string
    {
        $totalAmount = 0;
        $frequentRenterPoints = 0;
        $result = 'Rental Record for ' . $this->getName() . "\n";

        foreach ($this->rentals as $rental) {
            $frequentRenterPoints = $this->addFrequentRenterPoints($frequentRenterPoints, $rental);

            // add footer lines
            $result .= "\t" . $rental->getMovie()->getTitle() . "\t" . $this->getAmountForRental($rental) . "\n";

            $totalAmount += $this->getAmountForRental($rental);
        }
        // CAND NU repeti un apel de functie
        // - bug1 - face chestii (side effects) aka INSERT, send rabbit, gherman, ...
        // - bug2 - intoarce altceva la al doilea apel - nu e IDEMPOTENTA (corect NU e REFERENTIAL TRANSPARENT)
        // - concern - performanta (dureaza timp)

        // PURE function  = nu face side effects si intoarce acelasi rezultat apelata cu aceiasi param

        $result .= 'You owed ' . $totalAmount . "\n";
        $result .= 'You earned ' . $frequentRenterPoints . " frequent renter points\n";
        return $result;
    }

    /**
     * @param Rental $rental
     * @param int $thisAmount
     * @return float|int
     */
    private function getAmountForRental(Rental $rental)
    {
         $thisAmount = 0;
// determines the amount for each line
        switch ($rental->getMovie()->getPriceCode()) {
            case Movie::REGULAR:
                $thisAmount += 2;
                if ($rental->getDaysRented() > 2)
                    $thisAmount += ($rental->getDaysRented() - 2) * 1.5;
                break;
            case Movie::NEW_RELEASE:
                $thisAmount += $rental->getDaysRented() * 3;
                break;
            case Movie::CHILDREN:
                $thisAmount += 1.5;
                if ($rental->getDaysRented() > 3)
                    $thisAmount += ($rental->getDaysRented() - 3) * 1.5;
                break;
            default:
                $thisAmount = 0;
            // EZIT oare 0 e corect sau exceptie !?
            // throw new \Exception('Unexpected value ' . $rental->getMovie()->getPriceCode());
        }
        return $thisAmount;
    }

    /**
     * @param int $frequentRenterPoints
     * @param Rental $rental
     * @return int
     */
    private function addFrequentRenterPoints(int $frequentRenterPoints, Rental $rental): int
    {
// add frequent renter points
        $frequentRenterPoints++;
        // add bonus for a two day new release rental
        if ($rental->getMovie()->getPriceCode() == Movie::NEW_RELEASE
            && $rental->getDaysRented() > 1)
            $frequentRenterPoints++;
        return $frequentRenterPoints;
    }


}