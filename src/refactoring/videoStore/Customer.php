<?php

namespace victor\refactoring\videoStore;

class Customer
{
    /** @var Rental[] */
    private array $rentals = [];


    public function __construct(private readonly string $name)
    {
    }


    public function setRental(Rental $rental): void
    {
        $this->rentals[] = $rental;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function generateRentalStatement(): string
    {
        return $this->generateHeader()
            . $this->generateBody()
            . $this->generateFooter();
    }

    public function computeTotalPoints(): int
    {
        $frequentRenterPoints = 0;
        foreach ($this->rentals as $rental) {
            $frequentRenterPoints += $rental->calculateFrequentRenterPoints();
        }
        return $frequentRenterPoints;
    }

    public function computeTotalAmount(): float
    {
        $totalAmount = 0;
        foreach ($this->rentals as $rental) {
            $totalAmount += $rental->calculateRentalAmount();
        }
        return $totalAmount;
    }

    public function generateHeader(): string
    {
        return "Rental Record for {$this->getName()}\n";
    }

    public function generateBody(): string
    {
        $body = "";
        foreach ($this->rentals as $rental) {
            $body .= "\t{$rental->getMovie()->getTitle()}\t{$rental->calculateRentalAmount()}\n";
        }
        return $body;
    }

    public function generateFooter(): string
    {
        return "You owed {$this->computeTotalAmount()}\n" .
            "You earned {$this->computeTotalPoints()} frequent renter points\n";
    }


}
