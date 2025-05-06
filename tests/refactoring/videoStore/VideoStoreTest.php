<?php
namespace victor\refactoring\videoStore;

use PHPUnit\Framework\TestCase;

class VideoStoreTest extends TestCase {

    public function testRentalStatementFormat(): void
    {
        $customer = new Customer('John');
        $customer->setRental(new Rental(new Movie('Star Wars', PriceCode::NEW_RELEASE), 6));
        $customer->setRental(new Rental(new Movie('Sofia', PriceCode::CHILDREN), 7));
        $customer->setRental(new Rental(new Movie('Inception', PriceCode::REGULAR), 5));


        $this->assertEquals(
            "Rental Record for John\n" .
            "\tStar Wars\t18\n" .
            "\tSofia\t7.5\n" .
            "\tInception\t6.5\n" .
            "You owed 32\n" .
            "You earned 4 frequent renter points\n",
            $customer->generateRentalStatement());
    }
}
