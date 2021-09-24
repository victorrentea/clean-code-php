<?php


namespace victor\clean;

// class CevaDinDb {
//     private CevaDinDbMaiSpecific $abc;
//     private string $d;
//     private string $e;
//     private string $f;
//     private string $g;
//     private string $h;
//     private string $i;
// }
// class CevaDinDbMaiSpecific {
//     private string $a;
//     private string $b;
//     private string $c;
// }
// class SearchCriteria {
//     publi string $name;
//     publi string $phone;
//     publi string $address;
//     publi string $age;
// }

echo "#sieu ". (new Interval(2012, 2018))->intersects(new Interval(2005, 2013)) . "\n";
echo "#sieu ". (new Interval(2012, 2018))->intersects(new Interval(2005, 2013)) . "\n";
echo "#sieu ". (new Interval(2012, 2018))->intersects(new Interval(2005, 2013)) . "\n";
echo "#sieu ". (new Interval(2012, 2018))->intersects(new Interval(2005, 2013)) . "\n";

class UtilsVsVO
{

    /**
     * @param CarModel[] $models
     */
    public function filterCarModels(CarSearchCriteria $criteria, array $models)
    {
        $result = [];
        $criteriaInterval = new Interval($criteria->getStartYear(), $criteria->getEndYear());
        foreach ($models as $model) {
            if ($model->getYearInterval()->intersects($criteriaInterval)) {
                $result [] = $model;
            }
        }
        return $result;
    }

}
class Interval {
    private int $start;
    private int $end;

    public function __construct(int $start, int $end)
    {
        if ($start > $end) throw new \Exception("start larger than end");
        $this->start = $start;
        $this->end = $end;
    }


    // http://world.std.com/~swmcd/steven/tech/interval.html
    public function intersects(Interval $other): int
    {
        return $this->getStart() <= $other->getEnd() && $other->getStart() <= $this->getEnd();
    }
    public function getEnd(): int
    {
        return $this->end;
    }
    public function getStart(): int
    {
        return $this->start;
    }
}


class CarSearchCriteria
{
    private $startYear;
    private $endYear;
    // samd

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


// cate campuri are entitatea aia a voastra MARE
// 50 Order
function m(Product $product) {
}


class CarModel // mapata pe baza !! PANICA
{
    private string $make;
    private $model;
    private Interval $yearInterval;

    public function __construct(int $startYear, int $endYear, string $model, string $make)
    {
        $this->yearInterval = new Interval($startYear, $endYear);
        $this->model = $model;
        $this->make = $make;
        $this->validateMe();
    }

    public function validateMe(): void {
        $this->validateMake($this->make);
        $this->validateModel($this->model);
        if ($this->make == null && $this->model == null) {
            throw new \Exception();
        }
        // e ok cu model=null dar atunci make nu mai poate fi NULL

        // make:BMW model:A5  -- asta cam miroase a DB SELECT ..
        // adresa: Daca ai pus Apartament, trebuie si Etaj. Dar pot totodata ambele lipsi
        // street number ===> Street Name
    }


    public function setMake(string $make): void
    {
        $this->validateMake($make);
        $this->make = $make;
    }


    public function getYearInterval(): Interval
    {
        return $this->yearInterval;
    }

    public function setYearInterval(Interval $yearInterval): void
    {
        $this->yearInterval = $yearInterval;
    }

    private function validateMake(string $make): void
    {
        if ($make == "" || strlen($make) < 3) {
            throw new \Exception("Empty make");
        }
    }

}

// in codul existen, inlocuiest
// $carModel->getStartYear() cu
// $carModel->getYearInterval()->getStart()

class CustomerId {
    private int $id;
}
class Order {
    private StreetAddress $streetAddress;
}
class StreetAddress {
    private string $name;
    private ?int $number;

    public function __construct(string $name, ?int $number)
    {
        $this->name = $name;
        $this->number = $number;
    }


}