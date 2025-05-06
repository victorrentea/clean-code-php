<?php
namespace victor\refactoring\videoStore;

class Customer
{
    private string $name;

    private array $rentals = array();


    public function __construct(string $name) {
        $this->name = $name;
    }


    public function addRental (Rental $rental): void
    {
        $this->rentals[] = $rental;
    }


    public function getName (): string
    {
        return $this->name;
    }


    public function setName (string $name): void
    {
        $this->name = $name;
    }


    public function generateRentalStatement (): string
    {
        $totalAmount = 0;
        $frequentRenterPoints = 0;
        $result = 'Rental Record for ' . $this->getName() . "\n";

        foreach ($this->rentals as $rental) {
            $amount = $this->calculateAmount($rental);
            $points = $this->calculateFrequentRenterPoints($rental);

            $result .= "\t" . $rental->getMovie()->getTitle() . "\t" . $amount . "\n";

            $totalAmount += $amount;
            $frequentRenterPoints += $points;
        }

        $result .= 'You owed ' . $totalAmount . "\n";
        $result .= 'You earned ' . $frequentRenterPoints . " frequent renter points\n";

        return $result;
    }


    private function calculateAmount($rental): float
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
