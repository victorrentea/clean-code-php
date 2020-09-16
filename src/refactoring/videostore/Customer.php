<?php

namespace victor\refactoring\videostore;

class Customer
{
    private string $name;

    /** @var Rental[] */
    private array $rentals = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addRental(Rental $rental): void
    {
        $this->rentals[] = $rental;
    }

    public function statement(): string
    {
        $rentals = $this->rentals;
        $result = 'Rental Record for ' . $this->getName() . "\n";

        $totalAmount = $this->computeTotalAmount($rentals);

        $frequentRenterPoints = $this->computeTotalRenterPoints($rentals);
        $result .= $this->formatLines($rentals);

        $result .= $this->formatFooter($totalAmount, $frequentRenterPoints);
        return $result;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param Rental $each
     * @return float|int
     * @throws \Exception
     */
    private function determineAmountsForLine(Rental $each)
    {
        $thisAmount = 0;

        // determines the amount for each line
        switch ($each->getMovie()->getType()) {
            case Movie::TYPE_REGULAR:
                $thisAmount += 2;
                if ($each->getDaysRented() > 2)
                    $thisAmount += ($each->getDaysRented() - 2) * 1.5;
                break;
            case Movie::TYPE_NEW_RELEASE:
                $thisAmount += $each->getDaysRented() * 3;
                break;
            case Movie::TYPE_CHILDREN:
                $thisAmount += 1.5;
                if ($each->getDaysRented() > 3)
                    $thisAmount += ($each->getDaysRented() - 3) * 1.5;
                break;
            default:
                throw new \Exception('Unexpected value ' . $each->getMovie()->getType());
        }
        return $thisAmount;
    }


    /**
     * @param Rental[] $rentals
     */
    private function formatLines(array $rentals): string
    {
        $result = "";
        foreach ($rentals as $rental) {
            $result .= "\t" . $rental->getMovie()->getTitle() . "\t" . $this->determineAmountsForLine($rental) . "\n";
        }
        return $result;
    }

    private function formatFooter(int $totalAmount, int $frequentRenterPoints): string

    {
//        return <<<TEXT
//You owed $totalAmount
//You earned $frequentRenterPoints frequent renter points
//
//TEXT;
        return "You owed {$totalAmount}\nYou earned {$frequentRenterPoints} frequent renter points\n";
    }

    /**
     * @param Rental[] $rentals
     */
    private function computeTotalAmount(array $rentals): float
    {
        $totalAmount = 0;
        foreach ($rentals as $rental) {
            $totalAmount += $this->determineAmountsForLine($rental);
        }
        return $totalAmount;
    }

    /**
     * @param Rental[] $rentals
     */
    private function computeTotalRenterPoints(array $rentals): int
    {
        $frequentRenterPoints = 0;
        foreach ($rentals as $rental) {
            // add frequent renter points
            $frequentRenterPoints++;

            // add bonus for a two day new release rental
            $movie = $rental->getMovie();
            $isNewRelease = $this->isNewRelease($movie);
            if ($isNewRelease && $rental->getDaysRented() > 1)
                $frequentRenterPoints++;
        }
        return $frequentRenterPoints;
    }

    /**
     * @param Movie $movie
     * @return bool
     */
    private function isNewRelease(Movie $movie): bool
    {
        return $movie->getType()-> == Movie::TYPE_NEW_RELEASE;
    }

}