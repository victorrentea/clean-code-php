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

    public function generateStatement(): string
    {
        $totalPrice = 0;
        $frequentRenterPoints = 0;
        $result = 'Rental Record for ' . $this->getName() . "\n";

        foreach ($this->rentals as $rental) {
            $frequentRenterPoints += $rental->getFrequentRenterPoints();

            // add footer lines
            $result .= "\t" . $rental->getMovie()->getTitle() . "\t" . $rental->computePrice() . "\n";

            $totalPrice += $rental->computePrice();
        }

        $result .= 'You owed ' . $totalPrice . "\n";
        $result .= 'You earned ' . $frequentRenterPoints . " frequent renter points\n";
        return $result;
    }


}