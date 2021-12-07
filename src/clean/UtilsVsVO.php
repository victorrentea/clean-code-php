<?php


namespace victor\clean;


class UtilsVsVO
{
    /**
     * @param CarModel[] $models
     */
    public function filterCarModels(CarSearchCriteria $criteria, array $models)
    {
        $result = [];

        foreach ($models as $model) {
            $modelInterval = new Interval($model->getStartYear(), $model->getEndYear());
            $criteriaInterval = new Interval($criteria->getStartYear(), $criteria->getEndYear());
            if ($modelInterval->intersects($criteriaInterval)) {
                $result [] = $model;
            }
        }
        return $result;
    }

}

// class Timestamp {
//     private int $timestamp;
//
//     public function __construct(int $timestamp)
//     {
//         if ($timestamp nu e data valida) {
//             throw
//     }
//         $this->timestamp = $timestamp;
//     }
//
// }
class Interval {
    private int $start;
    private int $end;

    public function __construct(int $start, int $end)
    {
        if ($start > $end) {
            throw new \Exception("start larger than end");
        }
        $this->start = $start;
        $this->end = $end;
    }
    public function intersects(Interval $other): bool
    {
        return $this->getStart() <= $other->getEnd() && $other->getStart() <= $this->getEnd();
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


class CarModel
{
    private $make;
    private $model;
    private Interval $interval;

    public function __construct(Interval $interval, string $model, string $make)
    {
        $this->model = $model;
        $this->make = $make;
        $this->interval = $interval;
    }

    public function getInterval(): Interval
    {
        return $this->interval;
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