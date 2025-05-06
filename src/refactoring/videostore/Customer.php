<?php
namespace victor\refactoring\videostore;

class Customer
{
    /**
     * @param Rental[] $rentals
     */
    public function __construct(
        private readonly string $name,
        private array $rentals = []
    ) {
    }


    public function addRental(Rental $rental): void
    {
        $this->rentals[] = $rental;
    }


    public function getMovieRentalStatement(): string {
        $totalAmount = 0;
        $frequentRenterPoints = 0;
        $result = 'Rental Record for ' . $this->getName() . "\n";

        foreach ($this->rentals as $rental) {
            $rentalAmount = $this->getRentalAmount($rental);
            $frequentRenterPoints += $this->getFrequentRenterPoints($rental);
            $totalAmount += $rentalAmount;
            $result .= "\t" . $rental->getMovie()->getTitle() . "\t" . $rentalAmount . "\n";
        }

        $result .= 'You owed ' . $totalAmount . "\n";
        $result .= 'You earned ' . $frequentRenterPoints . " frequent renter points\n";

        return $result;
    }


    private function calculateRentalAmount(int $days, float $value): float
    {
        return $days * $value;
    }


    private function getRentalAmount(Rental $rental): float
    {
        $daysRented = $rental->getDaysRented();
        return match ($rental->getMovie()->getPriceCode()) {
            PriceCodeEnum::REGULAR => ($daysRented > 2)
                ? (2 +  $this->calculateRentalAmount($daysRented - 2, 1.5))
                : 2 + $daysRented,
            PriceCodeEnum::NEW_RELEASE => $this->calculateRentalAmount($daysRented, 3),
            PriceCodeEnum::CHILDREN => ($daysRented > 3)
                ? (1.5 + $this->calculateRentalAmount($daysRented - 3 , 1.5))
                : 1.5 + $daysRented,
        };
    }


    private function getFrequentRenterPoints(Rental $rental): int
    {
        $frequentRenterPoints = 1;
        // add bonus for a two day new release rental
        if ($rental->getMovie()->getPriceCode() == PriceCodeEnum::NEW_RELEASE
            && $rental->getDaysRented() > 1)
            $frequentRenterPoints++;

        return $frequentRenterPoints;
    }


    private function getName(): string {
        return $this->name;
    }
}

