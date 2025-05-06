<?php
namespace victor\refactoring\videostore;

use PHPUnit\Framework\TestCase;

class VideoStoreTest extends TestCase {

    const MOVIE_TITLE_1 = 'Star Wars';
    const MOVIE_TITLE_2 = 'Sofia';
    const MOVIE_TITLE_3 = 'Inception';
    const CUSTOMER_NAME = 'John';


    public function testRentalStatementFormat(): void
    {
        $customer = new Customer(self::CUSTOMER_NAME);
        $customer->addRental(new Rental(new Movie(self::MOVIE_TITLE_1,PriceCodeEnum::NEW_RELEASE), 6));
        $customer->addRental(new Rental(new Movie(self::MOVIE_TITLE_2,PriceCodeEnum::CHILDREN), 7));
        $customer->addRental(new Rental(new Movie(self::MOVIE_TITLE_3,PriceCodeEnum::REGULAR), 5));

        $this->assertEquals(
            "Rental Record for John\n" .
            "\tStar Wars\t18\n" .
            "\tSofia\t7.5\n" .
            "\tInception\t6.5\n" .
            "You owed 32\n" .
            "You earned 4 frequent renter points\n",
            $customer->getMovieRentalStatement());
    }
}
