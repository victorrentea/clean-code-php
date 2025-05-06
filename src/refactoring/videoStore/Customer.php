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
        $totalAmount = 0;
        $frequentRenterPoints = 0;
        $result = "Rental Record for {$this->getName()}\n";

        foreach ($this->rentals as $rental) {
            $result .= "\t{$rental->getMovie()->getTitle()}\t{$rental->calculateRentalAmount()}\n";
        }

        foreach ($this->rentals as $rental) {
           $totalAmount += $rental->calculateRentalAmount();
        }

        foreach ($this->rentals as $rental) {
            $frequentRenterPoints += $rental->calculateFrequentRenterPoints();
        }

        $result .= "You owed {$totalAmount}\n";
        $result .= "You earned {$frequentRenterPoints} frequent renter points\n";

        return $result;
    }


}
