<?php


namespace victor\clean;


class UtilsVsVO
{
    public function filterCarModels(CarSearchCriteria $criteria, array $models)
    {
        $result = [];
        /** @var CarModel $model */
        foreach ($models as $model) {
            $modelInterval = new Interval($model->getStartYear(), $model->getEndYear());
            if ($modelInterval ->intersects($criteria->getYearInterval())) {

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
        $this->start = $start;
        $this->end = $end;
        if ($start > $end) {
            throw new \Exception();
        }
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
        return $this->start <= $other->end
            && $other->start <= $this->end;
    }
}

class OtherClass {
    function f() {
        $interval1 = new Interval(1, 3);
        ($interval1)->intersects(new Interval(2, 4));
    }
}
class MathUtil {

    public static function intervalIntersect(Interval $interval1, Interval $interval2): bool
    {
        return $interval1->intersects($interval2);
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

//    public function getStartYear(): int
//    {
//        return $this->startYear;
//    }
//
//    public function getEndYear(): int
//    {
//        return $this->endYear;
//    }

    public function getYearInterval(): Interval
    {
        return new Interval($this->startYear, $this->endYear);
    }
}


class CarModel
{
    private $make;
    private $model;
    private $startYear;
    private $endYear;
//    private Interval $productionYears;

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
}