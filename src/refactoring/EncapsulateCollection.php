<?php


namespace victor\refactoring;

$hotelCharges = new HotelCharges();

$dayCharge = new HotelDayCharge(100, true, 5);

//$hotelCharges->days[] = $dayCharge;
$hotelCharges->addDay($dayCharge);

echo 'FEE: ' . $hotelCharges->computeTotal() . "\n";

//$hotelCharges->computeTotal();
//$hotelCharges->totalFee

echo 'FEE: ' . $hotelCharges->computeTotal() . "\n";



class HotelCharges
{
    const BREAKFAST_FEE = 10;
    const PARKING_HOUR_RATE = 2;
    /** @var HotelDayCharge[] */
    private $days = [];
//    /** @var int */
//    private $totalFee;

//    public function getTotalFee(): int
//    {
//        return $this->totalFee;
//    }
    function addDay(HotelDayCharge $dayCharge)
    {
        $this->days[] = $dayCharge;
//        $this->computeTotal();
    }

    public function computeTotal()
    {
        $this->totalFee = 0;
        /** @var HotelDayCharge $day */
        foreach ($this->days as $day) {
            $this->totalFee += $day->getDayRate();
            if ($day->isBreakfast()) {
                $this->totalFee += self::BREAKFAST_FEE;
            }
            $this->totalFee += $day->getParkingHours() * self::PARKING_HOUR_RATE;
        }
    }
}

class HotelDayCharge
{
    private $dayRate;
    private $breakfast;
    private $parkingHours;
    private $hotel;

    public function __construct(int $dayRate, bool $breakfastFee, int $parkingHours)
    {
        $this->dayRate = $dayRate;
        $this->breakfast = $breakfastFee;
        $this->parkingHours = $parkingHours;
    }

    public function setHotel(HotelCharges $hotel): void
    {
        $this->hotel = $hotel;
    }

    public function getDayRate(): int
    {
        return $this->dayRate;
    }

    public function getParkingHours(): int
    {
        return $this->parkingHours;
    }

    public function isBreakfast(): bool
    {
        return $this->breakfast;
    }

}