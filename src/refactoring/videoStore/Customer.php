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
        $result = 'Rental Record for ' . $this->getName() . "\n";

        foreach ($this->rentals as $rental) {
            $rentalAmount = $this->calculateRentalAmount($rental);
            $points = $this->calculateFrequentRenterPoints($rental);

            $result .= sprintf("\t%s\t%.2f\n", $rental->getMovie()->getTitle(), $rentalAmount);

            $totalAmount += $rentalAmount;
            $frequentRenterPoints += $points;
        }

        $result .= sprintf("You owed %.2f\n", $totalAmount);
        $result .= sprintf("You earned %d frequent renter points\n", $frequentRenterPoints);

        return $result;
    }


    private function calculateRentalAmount($rental): float
    {
        $days = $rental->getDaysRented();

        return match ($rental->getMovie()->getPriceCode()) {
            Movie::REGULAR => 2 + max(0, ($days - 2) * 1.5),
            Movie::NEW_RELEASE => $days * 3.0,
            Movie::CHILDRENS => 1.5 + max(0, ($days - 3) * 1.5),
            default => 0.0,
        };
    }


    private function calculateFrequentRenterPoints($rental): int
    {
        $points = 1;
        if ($rental->getMovie()->getPriceCode() === Movie::NEW_RELEASE && $rental->getDaysRented() > 1) {
            $points++;
        }

        return $points;
    }
}
