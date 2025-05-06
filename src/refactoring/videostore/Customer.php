<?php
namespace victor\refactoring\videostore;

use http\Exception\InvalidArgumentException;

class Customer
{
    /**
     * @var Rental[] $rentals
     */
    private array $rentals = [];

    public function __construct(private string $name) {
    }

    public function addRental(Rental $rental) : void
    {
        $this->rentals[] = $rental;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function statement(): string
    {
        $totalAmount = 0;
        $frequentRenterPoints = 0;
        $result = 'Rental Record for ' . $this->name . "\n";

        foreach ($this->rentals as $rental) {
            $rentalAmount = $rental->getRentalAmount();
            $frequentRenterPoints += $this->getFrequentRenterPoints($rental);

            $result .= "\t" . $rental->getMovie()->getTitle() . "\t" . $rentalAmount . "\n";
            $totalAmount += $rentalAmount;
        }

        $result .= 'You owed ' . $totalAmount . "\n";
        $result .= 'You earned ' . $frequentRenterPoints . " frequent renter points\n";

        return $result;
    }

    private function getFrequentRenterPoints(Rental $rental): int
    {
        return ($rental->getMovie()->getPriceCode() == PriceCode::NEW_RELEASE
            && $rental->getDaysRented() > 1) ? 2: 1;
    }
}
