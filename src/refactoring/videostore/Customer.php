<?php declare(strict_types = 1);

namespace victor\refactoring\videostore;

use victor\refactoring\videostore\Constants;
class Customer
{
    private string $name;

    /**
     * @var Rental[]
     */
    private array $rentals = [];

    /**
     * Customer constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Add a rental to this customer.
     *
     * @param Rental $rental
     */
    public function addRental(Rental $rental): void
    {
        $this->rentals[] = $rental;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Rental[]
     */
    public function getRentals(): array
    {
        return $this->rentals;
    }

    public function statement(): string
    {
        $rentalSummary = $this->calculateRentalSummary();

        $statementParts = [
            sprintf(Constants::RENTAL_RECORD_HEADER, $this->getName()),
            $this->formatRentalLines($this->rentals),
            sprintf(Constants::AMOUNT_OWED_FORMAT, $rentalSummary['totalAmount']),
            sprintf(Constants::POINTS_EARNED_FORMAT, $rentalSummary['frequentRenterPoints'])
        ];

        return implode('', $statementParts);
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
