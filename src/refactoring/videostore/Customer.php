<?php
namespace victor\refactoring\videostore;

class Customer
{
    /**
     * @var Rental[] $rentals
     */
    private array $rentals = [];
    const MAX_RENTAL_REGULAR = 2;
    const MAX_RENTAL_CHILDREN = 3;

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
        $totalAmount 			= 0;
        $frequentRenterPoints 	= 0;
        $rentals 				= $this->rentals;
        $result 			= 'Rental Record for ' . $this->name . "\n";

        foreach ($rentals as $rental) {
            $rentalAmount = 0;

            // determines the amount for rental line
            $daysRented = $rental->getDaysRented();
            switch ($rental->getMovie()->getPriceCode()) {
                case PriceCode::REGULAR:
                    $rentalAmount += 2;
                    if ($daysRented > self::MAX_RENTAL_REGULAR)
                        $rentalAmount += ($daysRented - self::MAX_RENTAL_REGULAR) * 1.5;
                    break;
                case PriceCode::NEW_RELEASE:
                    $rentalAmount += $daysRented * 3;
                    if($daysRented > 1)
                        $frequentRenterPoints++;
                    break;
                case PriceCode::CHILDREN:
                    $rentalAmount += 1.5;
                    if ($daysRented > self::MAX_RENTAL_CHILDREN)
                        $rentalAmount += ($daysRented - self::MAX_RENTAL_CHILDREN) * 1.5;
                    break;
            }

            // add frequent renter points
            $frequentRenterPoints++;

            // add footer lines
            $result .= "\t" . $rental->getMovie()->getTitle() . "\t"
                . $rentalAmount . "\n";
            $totalAmount += $rentalAmount;

        }

        $result .= 'You owed ' . $totalAmount . "\n";
        $result .= 'You earned ' . $frequentRenterPoints . " frequent renter points\n";


        return $result;
    }
}
