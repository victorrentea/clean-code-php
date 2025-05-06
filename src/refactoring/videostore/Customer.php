<?php
namespace victor\refactoring\videostore;

class Customer
{
    /**
     * @param Rental[] $rentals
     */
    public function __construct(private string $name, private array $rentals = [])
    {
    }

    public function addRental(Rental $rental): void
    {
        $this->rentals[] = $rental;
    }


    public function getName(): string {
        return $this->name;
    }


    public function setName(string $name): void {
        $this->name = $name;
    }

    public function statement(): string {
        $totalAmount = 0;
        $frequentRenterPoints = 0;
        $result = 'Rental Record for ' . $this->getName() . "\n";

        foreach ($this->rentals as $rental) {
            $thisAmount = 0;
            // determines the amount for rental line
            $thisAmount = $this->getAmount($rental, $thisAmount);

            // add frequent renter points
            $frequentRenterPoints++;

            // add bonus for a two day new release rental
            if ($rental->getMovie()->getPriceCode() == PriceCodeEnum::NEW_RELEASE
                && $rental->getDaysRented() > 1)
                $frequentRenterPoints++;

            // add footer lines
            $result .= "\t" . $rental->getMovie()->getTitle() . "\t"
                . $thisAmount . "\n";
            $totalAmount += $thisAmount;

        }

        $result .= 'You owed ' . $totalAmount . "\n";
        $result .= 'You earned ' . $frequentRenterPoints . " frequent renter points\n";


        return $result;
    }

    private function calculateRentalAmount(int $days, float $value): float
    {
        return $days * $value;
    }


    private function getAmount(Rental $rental, int $thisAmount): float
    {
        $daysRented = $rental->getDaysRented();
        switch ($rental->getMovie()->getPriceCode()) {
            case PriceCodeEnum::REGULAR:
                if ($daysRented > 2)
                    $thisAmount += 2 + $this->calculateRentalAmount($daysRented - 2, 1.5);
                break;
            case PriceCodeEnum::NEW_RELEASE:
                $thisAmount += $this->calculateRentalAmount($daysRented, 3);
                break;
            case PriceCodeEnum::CHILDREN:
                $thisAmount += 1.5;
                if ($daysRented > 3)
                    $thisAmount += $this->calculateRentalAmount($daysRented - 3, 1.5);
                break;
            default:
                $thisAmount += 0;
        }

        return $thisAmount;
    }


    private function getAmount2(Rental $rental, int $thisAmount): float
    {
        $daysRented = $rental->getDaysRented();
        switch ($rental->getMovie()->getPriceCode()) {
            case PriceCodeEnum::REGULAR:
                if ($daysRented > 2)
                    $thisAmount += 2 + $this->calculateRentalAmount($daysRented - 2, 1.5);
                break;
            case PriceCodeEnum::NEW_RELEASE:
                $thisAmount += $this->calculateRentalAmount($daysRented, 3);
                break;
            case PriceCodeEnum::CHILDREN:
                $thisAmount += 1.5;
                if ($daysRented > 3)
                    $thisAmount += $this->calculateRentalAmount($daysRented - 3, 1.5);
                break;
            default:
                $thisAmount += 0;
        }

        return $thisAmount;
    }
}
