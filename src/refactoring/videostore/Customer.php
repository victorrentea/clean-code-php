<?php declare(strict_types = 1);

namespace victor\refactoring\videostore;

use victor\refactoring\videostore\Constants;
class Customer
{
    const RECORD_HEADER = "Rental Record for %s\n";
    private string $name;

    /**
     * @var Rental[]
     */
    private array $rentals = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addRental(Rental $rental): void
    {
        $this->rentals[] = $rental;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function statement(): string
    {
        $rentalSummary = $this->calculateRentalSummary();

        $result = sprintf(self::RECORD_HEADER, $this->getName());
        $result .= $this->formatRentalLines($this->rentals);
        $result .= "You owed {$rentalSummary['totalAmount']}\n";
        $result .= "You earned {$rentalSummary['frequentRenterPoints']} frequent renter points\n";
        return $result;
    }

    private function calculateRentalSummary(): array
    {
        return array_reduce(
            $this->rentals,
            function (array $summary, Rental $rental) {
                $summary['totalAmount'] += $rental->getCharge();
                $summary['frequentRenterPoints'] += $rental->getFrequentRenterPoints();
                return $summary;
            },
            ['totalAmount' => 0.0, 'frequentRenterPoints' => 0]
        );
    }

    private function formatRentalLines(array $rentals): string
    {
        return implode('', array_map(
            fn(Rental $rental) => "\t{$rental->getMovie()->getTitle()}\t" . $rental->getCharge() . "\n",
            $rentals
        ));
    }
}
