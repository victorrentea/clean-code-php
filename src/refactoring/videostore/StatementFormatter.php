<?php


namespace victor\refactoring\videostore;


class StatementFormatter
{

    /**
     * @param Rental[] $rentals
     */
    public function formatStatement(string $customerName, array $rentals): string
    {
        return $this->formatHeader($customerName)
            . $this->formatBody($rentals)
            . $this->formatFooter($rentals);
    }

    /**
     * @param Rental[] $rentals
     */
    private function formatBody(array $rentals): string
    {
        $result = "";
        foreach ($rentals as $rental) {
            $result .= $this->formatBodyLine($rental);
        }
        return $result;
    }

    private function formatBodyLine(Rental $rental): string
    {
        return "\t" . $rental->getMovie()->getTitle() . "\t" . $rental->computePrice() . "\n";
    }

    /**
     * @param Rental[] $rentals
     */
    private function computeTotalAmount(array $rentals): float
    {
        $totalAmount = 0;
        foreach ($rentals as $rental) {
            $totalAmount += $rental->computePrice();
        }
        return $totalAmount;
    }

    private function computeTotalRenterPoints(array $rentals): int
    {
        return array_reduce($rentals, function($sum, Rental $r) {return $sum + $r->computeRenterPoints();}, 0);
    }

    private function formatFooter(array $rentals): string
    {
        $totalAmount = $this->computeTotalAmount($rentals);
        $totalPoints = $this->computeTotalRenterPoints($rentals);
        //        return <<<TEXT
        //You owed $totalAmount
        //You earned $frequentRenterPoints frequent renter points
        //
        //TEXT;
        return "You owed $totalAmount\nYou earned $totalPoints frequent renter points\n";
    }

    private function formatHeader(string $customerName): string
    {
        return 'Rental Record for ' . $customerName . "\n";
    }
}