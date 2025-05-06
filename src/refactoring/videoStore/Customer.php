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
            $result .= "\t{$rental->getMovie()->getTitle()}\t{$this->calculateRentalAmount($rental)}\n";
        }

        foreach ($this->rentals as $rental) {
           $totalAmount += $this->calculateRentalAmount($rental);
        }

        foreach ($this->rentals as $rental) {
            $frequentRenterPoints += $this->calculateFrequentRenterPoints($rental);
        }

        $result .= "You owed {$totalAmount}\n";
        $result .= "You earned {$frequentRenterPoints} frequent renter points\n";

        return $result;
    }


    private function calculateRentalAmount(Rental $rental): float
    {
        $days = $rental->getDaysRented();

        return match ($rental->getMovie()->getPriceCode()) {
            PriceCode::REGULAR => 2 + max(0, ($days - 2) * 1.5),
            PriceCode::NEW_RELEASE => $days * 3.0,
            PriceCode::CHILDREN => 1.5 + max(0, ($days - 3) * 1.5),
        };
    }


    private function calculateFrequentRenterPoints(Rental $rental): int
    {
        $points = 1;
        if ($rental->getMovie()->getPriceCode() === PriceCode::NEW_RELEASE && $rental->getDaysRented() > 1) {
            $points++;
        }

        return $points;
    }
}
