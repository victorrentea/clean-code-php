<?php

namespace victor\refactoring\videostore;

class Customer
{
    private string $name;
    /**
     * @var Rental[]
     */
    private array $rentals = array();

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addRental(Rental $rental)
    {
        $this->rentals[] = $rental;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function generateStatement(): string
    {
        return $this->createHeader()
            . $this->createBody()
            . $this->createFooter();
    }

    private function createHeader(): string
    {
        return "Rental Record for {$this->name}\n";
    }

    private function createBody(): string
    {
        $result = "";
        foreach ($this->rentals as $rental) {
            $result .= "\t" . $rental->getMovie()->getTitle() . "\t" . $rental->computePrice() . "\n";
        }
        return $result;
    }

    private function createFooter(): string
    {
        $totalPrice = $this->computeTotalPrice();
        $frequentRenterPoints = $this->computeTotalPoints();
        return 'You owed ' . $totalPrice . "\n"
            . 'You earned ' . $frequentRenterPoints . " frequent renter points\n";
    }

    private function computeTotalPrice(): float
    {
        $totalPrice = 0;
        foreach ($this->rentals as $rental) {
            $totalPrice += $rental->computePrice();
        }
        return $totalPrice;
    }

    private function computeTotalPoints(): int
    {
        $frequentRenterPoints = 0;
        foreach ($this->rentals as $rental) {
            $frequentRenterPoints += $rental->addFrequentRenterPoints();
        }
        return $frequentRenterPoints;
    }

}