<?php


namespace victor\clean;


class UtilsVsVO
{
    /**
     * @param CarModel[] $carModels
     * @return CarModel[]
     */
    public function filterCarModels(CarSearchCriteria $criteria, array $carModels): array
    {
//        $result = [];
//        foreach ($carModels as $carModel) {
//            if ($carModel->getYearInterval()->doesIntersect($criteria->getYearInterval())) {
//                $result [] = $carModel;
//            }
//        }
//        return $result;


//        return array_map() // => produce a collection of another type
//        return array_walk() // return true; just traverses the collection ~ foreach << avoid
//        return array_reduce() // uses an expression to aggregate a single resulting value

//        return array_filter($carModels,function (CarModel $carModel) use ($criteria) {
//            return $carModel->getYearInterval()->doesIntersect($criteria->getYearInterval());
//        });

        return array_filter($carModels, fn(CarModel $carModel) =>
            $carModel->getYearInterval()->doesIntersect($criteria->getYearInterval()));
    }
}



// Value Object design pattern = 💖immutable object lacking PK
/**@Embeddable*/
readonly class Interval{
    public function __construct(
        private int $start,
        private int $end
    ){
        if ($start > $end) {throw new \Exception("start larger than end");}
    }
    public function doesIntersect(Interval $other): bool
    { // behavior next to state = OOP. IFF you can CHANGE this class
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

echo new Interval(1,4)->doesIntersect(new Interval(2,5));
echo new Interval(1,4)->doesIntersect(new Interval(2,5));

class CarSearchCriteria
{
    private $startYear;
    private $endYear;

    public function __construct(int $startYear, int $endYear)
    {
        if ($startYear > $endYear) {
            throw new \Exception("start larger than end");
        }
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

    public function getYearInterval(): Interval
    {
        return new Interval($this->getStartYear(), $this->getEndYear());
    }
}


class CarModel
{
    private $make;
    private $model;
    private $startYear;
    private $endYear;
    // @Embedded
    // private Interval yearInterval; // change the structure of this class to reduce the number of its attributes
    // doable if this class belongs to my private internal DOMAIN MODEL, you should be able to adjust their structure without breakign anything outside
    // don't if you marshal/unmarshall this object as JSON to your clients.

    public function __construct(int $startYear, int $endYear, string $model, string $make)
    {
        if ($startYear > $endYear) throw new \Exception("start larger than end");
        $this->startYear = $startYear;
        $this->endYear = $endYear;
        $this->model = $model;
        $this->make = $make;
    }

    public function getStartYear(): int
    {
        return $this->startYear;
    }

    public function getEndYear(): int
    {
        return $this->endYear;
    }

    public function getYearInterval(): Interval
    {
        return new Interval($this->getStartYear(), $this->getEndYear());
    }
}
