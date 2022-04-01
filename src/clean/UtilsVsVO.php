<?php


namespace victor\clean;


class UtilsVsVO
{
    /** @param $models CarModel[] */
    public function filterCarModels(CarSearchCriteria $criteria, array $models): array
    {
        $result = [];
        foreach ($models as $model) {
            if ($model->getYearInterval()->intersects($criteria->getYearInterval())) {

                $result [] = $model;
            }
        }
        return $result;
    }

}
class Interval { // Value Object pattern
    private int $start;
    private int $end;

    public function __construct(int $start, int $end)
    {
        if ($start > $end) throw new \Exception("start larger than end");
        $this->start = $start;
        $this->end = $end;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getEnd(): int
    {
        return $this->end;
    }

    public function intersects(Interval $other): bool
    {
        return $this->getStart() <= $other->getEnd() && $other->getStart() <= $this->getEnd();
    }
}


// class IntersectsOb

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

    public function getYearInterval(): Interval
    {
        return new Interval($this->startYear, $this->endYear);
    }
}



// CAR_MODEL(START_YEAR
// in codul tau: startYear <<  START_YEAR
class CarModel
{
    private $make;
    private $model;
    private Interval $yearInterval;
    // private $startYear;
    // private $endYear;

    public function __construct(int $startYear, int $endYear, string $model, string $make)
    {
        if ($startYear > $endYear) throw new \Exception("start larger than end");
        $this->yearInterval = new Interval($startYear, $endYear);
        $this->model = $model;
        $this->make = $make;
    }

    public function getYearInterval(): Interval
    {
        return $this->yearInterval;
    }

}

$carModel = new CarModel();
$carModel->getYearInterval()->getStart();