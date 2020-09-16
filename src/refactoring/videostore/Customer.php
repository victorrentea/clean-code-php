<?php
namespace victor\refactoring\videostore;

class Customer
{
    public function __construct(string $name) {
        $this->name = $name;
    }

    public function addRental (Rental $rental) {
        $this->rentals[] = $rental;
    }


    /**
     * @return string
     */
    public function getName () {
        return $this->name;
    }


    /**
     * @param $name string
     */
    public function setName ($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function statement () {
        $totalAmount 			= 0;
        $frequentRenterPoints 	= 0;
        $rentals 				= $this->rentals;
        $result 			= 'Rental Record for ' . $this->getName() . "\n";

        foreach ($rentals as $each) {
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
                        $thisAmount += ($each->getDaysRented () - 3) * 1.5;
                    break;
            }

            // add frequent renter points
            $frequentRenterPoints++;

            // add bonus for a two day new release rental
            if ($each->getMovie()->getType() == Movie::TYPE_NEW_RELEASE
                && $each->getDaysRented() > 1)
                $frequentRenterPoints++;

            // add footer lines
            $result .= "\t" . $each->getMovie()->getTitle() . "\t"
                . $thisAmount . "\n";
            $totalAmount += $thisAmount;

        }

        $result .= 'You owed ' . $totalAmount . "\n";
        $result .= 'You earned ' . $frequentRenterPoints . " frequent renter points\n";


        return $result;
    }


    private $name;
    /**
     * @var Rental[]
     */
    private $rentals = array();
}