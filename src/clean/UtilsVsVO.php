<?php


namespace victor\clean;


use function victor\refactoring\horror;


function horrorDeLaMircea(int $id): void {
    $arr2 = [1];
    foreach ($arr2 as $id) { // variable hoisting suprascrie param long live stan!
        echo "Frate! $id";
    }
    echo "\nCeva cu $id trebuia 6 aici \n";
}

horrorDeLaMircea(6);

class UtilsVsVO
{
    /**
     * @param CarModel[] $carModels
     */
    public function filterCarModels(CarSearchCriteria $criteria, array $carModels)
    {
        $result = [];
        // /** @var CarModel $carModel */
        foreach ($carModels as $carModel) {
            $criteriaInterval = new Interval($criteria->getStartYear(), $criteria->getEndYear());
            if ($carModel->yearInterval()->intersects($criteriaInterval)) {
                $result [] = $carModel;
            }
        }
        return $result;
    }

    // http://world.std.com/~swmcd/steven/tech/interval.html
}
echo (new Interval(1, 3))->intersects((new Interval(2, 4)));

// class MathService { // nu-mi place ca ma gandesc  ca tre s-o iau injectata din symph
// class MathHelper {
class MathUtil {

}

class Interval {
    private int $start;
    private int $end;

    public function __construct(int $start, int $end)
    {
        // AICI
        if ($start > $end) throw new \Exception("mama ta care te-a facut");
        $this->start = $start;
        $this->end = $end;
    }

    public function intersects(Interval $other): bool {
        return $this->start <= $other->end && $other->start <= $this->end;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getEnd(): int
    {
        return $this->end;
    }
}

class CarSearchCriteria
{
    private $startYear;
    private $endYear;

    public function __construct(int $startYear, int $endYear)
    {
        if ($startYear > $endYear) throw new \Exception("start larger than end");
        $this->startYear = $startYear;
        $this->endYear = $endYear;
    }

    public function getStartYear(): int
    {
        return $this->startYear;
    }

    public function getEndYear(): int
    {
        return $this->endYear;
    }
}





// DDD   " VALUE OJBECTS"

class CarModel
{
    private $make;
    private $model;
    // private $startYear;
    // private $endYear;
    /** @ORM\Embedded(class="AppBundle\Entity\Embeddable\Interval") */
    private Interval $yearInterval;

    public function __construct(int $startYear, int $endYear, string $model, string $make)
    {
        $this->yearInterval = new Interval($startYear, $endYear);

        $this->model = $model;
        $this->make = $make;
    }

    // public function getStartYear()
    // {
    //     return $this->yearInterval->getStart();
    // }

    public function yearInterval(): Interval
    {
        return $this->yearInterval;
    }

    public function setMake(string $make): CarModel
    {
        $this->make = $make;
        return $this;
    }

    public function setModel(string $model): CarModel
    {
        $this->model = $model;
        return $this;
    }

    public function setYearInterval(Interval $yearInterval): CarModel
    {
        $this->yearInterval = $yearInterval;
        return $this;
    }
    // public function getYearInterval(): Interval
    // {
    //     return new Interval($this->startYear, $this->endYear);
    // }


}

// class ProductName {
//     private string $name;
// }

$carModel = new CarModel(2015, 2022, "Ford", "Focus");
echo $carModel->yearInterval()->getStart(); // BINE
// echo $carModel->getStartYear(); // RAU in 2022
echo $carModel->yearInterval()->getStart();
echo $carModel->yearInterval()->getStart();
echo $carModel->yearInterval()->getStart();


class Customer {
    private bool $isGenius;

    public function isGenius(): bool
    {
        return $this->isGenius;
    }
    function getDiscount():int {
        $discount = 1;
        if ($this->isGenius()) {
            $discount += 3;
        }
        return $discount;
    }
}

$customer = new Customer();

$discount = $customer->getDiscount();

echo $discount;


// $c = TestData::aCustomer()->withName(null);

