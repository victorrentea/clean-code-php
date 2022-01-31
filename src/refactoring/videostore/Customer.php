<?php

namespace victor\refactoring\videostore;

class Customer
{
    private string $name;
    /**
     * @var Rental[]
     */
    private array $rentals = [];

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

    // CAND NU repeti un apel de functie
    // - bug1 - face chestii (side effects) aka INSERT, send rabbit, gherman, ...
    // - bug2 - intoarce altceva la al doilea apel - nu e IDEMPOTENTA (corect NU e REFERENTIAL TRANSPARENT)
    // - concern - performanta (dureaza timp)

    // PURE function  = nu face side effects si intoarce acelasi rezultat apelata cu aceiasi param

    // TODO clasa Formatter care sa primeasca datele:  {rentals, customer, totalPoints, totalPrice} aka Split Phase refactor:
    // introduci un obiect care se plimba intre partea care calculeaza chestii si partea care doar formateaza
    public function generateStatement(): string
    {
        return $this->generateHeader()
            . $this->generateBody()
            . $this->generateFooter();
    }

    private function generateFooter(): string
    {
        return 'You owed ' . $this->computeTotalPrice() . "\n"
            . 'You earned ' . $this->computeTotalPoints() . " frequent renter points\n";
    }

    private function generateHeader(): string
    {
        return 'Rental Record for ' . $this->getName() . "\n";
    }

    private function generateStatementLine(Rental $rental): string
    {
        return "\t" . $rental->getMovie()->getTitle() . "\t" . $rental->computePrice() . "\n";
    }

    /**
     * @return float|int
     * @throws \Exception
     */
    private function computeTotalPrice()
    {
        $totalPrice = 0;
        foreach ($this->rentals as $rental) {
            $totalPrice += $rental->computePrice();
        }
        return $totalPrice;
    }

    /**
     * @return int
     */
    private function computeTotalPoints(): int
    {
        $frequentRenterPoints = 0;
        foreach ($this->rentals as $rental) {
            $frequentRenterPoints += $rental->getFrequentRenterPoints();
        }
        return $frequentRenterPoints;
    }

    private function generateBody(): string
    {
        $result = "";
        foreach ($this->rentals as $rental) {
            $result .= $this->generateStatementLine($rental);
        }
        return $result;
    }


}