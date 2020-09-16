<?php


namespace victor\refactoring\videostore;


class CevaCuStatement
{
    private Customer $customer;

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function statement(): string
    {
        return $this->formatHeader()
            . $this->formatBody()
            . $this->formatFooter();
    }

    private function formatBody(): string
    {
        $result = "";
        foreach ($this->customer->getRentals() as $rental) {
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
        foreach ($this->customer->getRentals() as $rental) {
            $totalAmount += $rental->determineAmountsForLine();
        }
        return $totalAmount;
    }

    private function computeTotalRenterPoints(): int
    {
        return array_reduce($this->customer->getRentals(), function($sum, Rental $r) {return $sum + $r->computeRenterPoints();}, 0);
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
        return 'Rental Record for ' . $this->customer->getName() . "\n";
    }
}