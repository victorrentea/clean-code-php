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
        return $this->formatHeader()
            . $this->formatBody()
            . $this->formatFooter();
    }

    public function getName(): string
    {
        return $this->name;
    }


    private function formatBody(): string
    {
        $result = "";
        foreach ($this->rentals as $rental) {
            $result .= $this->formatBodyLine($rental);
        }
        return $result;
    }

    private function formatBodyLine(Rental $rental): string
    {
        return "\t" . $rental->getMovie()->getTitle() . "\t" . $rental->determineAmountsForLine() . "\n";
    }

    private function computeTotalAmount(): float
    {
        $totalAmount = 0;
        foreach ($this->rentals as $rental) {
            $totalAmount += $rental->determineAmountsForLine();
        }
        return $totalAmount;
    }

    private function computeTotalRenterPoints(): int
    {
        return array_reduce($this->rentals, function($sum, Rental $r) {return $sum + $r->computeRenterPoints();}, 0);
    }

    private function formatFooter(): string
    {
        $totalAmount = $this->computeTotalAmount();
        $totalPoints = $this->computeTotalRenterPoints();
                //        return <<<TEXT
        //You owed $totalAmount
        //You earned $frequentRenterPoints frequent renter points
        //
        //TEXT;
        return "You owed $totalAmount\nYou earned $totalPoints frequent renter points\n";
    }

    private function formatHeader(): string
    {
        return 'Rental Record for ' . $this->getName() . "\n";
    }

}