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


    private function formatBody(): string
    {
        $result = "";
        foreach ($this->rentals as $rental) {
            $result .= "\t" . $rental->getMovie()->getTitle() . "\t" . $this->determineAmountsForLine($rental) . "\n";
        }
        return $result;
    }

    private function computeTotalAmount(): float
    {
        $totalAmount = 0;
        foreach ($this->rentals as $rental) {
            $totalAmount += $this->determineAmountsForLine($rental);
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