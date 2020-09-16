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
        $totalAmount = 0;
        $frequentRenterPoints = 0;
        $rentals = $this->rentals;
        $result = 'Rental Record for ' . $this->getName() . "\n";

        foreach ($rentals as $each) {
            $totalAmount += $this->determineAmountsForLine($each);
        }

        foreach ($rentals as $each) {
            // add frequent renter points
            $frequentRenterPoints++;

            // add bonus for a two day new release rental
            if ($each->getMovie()->getType() == Movie::TYPE_NEW_RELEASE
                && $each->getDaysRented() > 1)
                $frequentRenterPoints++;
        }
        $result .= $this->formatLines($rentals);

        // add footer lines
        $result .= 'You owed ' . $totalAmount . "\n";
        $result .= 'You earned ' . $frequentRenterPoints . " frequent renter points\n";
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

}