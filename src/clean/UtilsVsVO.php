<?php


namespace victor\clean;


use Exception;

class UtilsVsVO
{
    public function filterCarModels(CarSearchCriteria $criteria, array $models)
    {

        // $criteriaInterval = new Interval($criteria->getStartYear(), $criteria->getEndYear());
        $result = [];
        /** @var CarModel $model */
        foreach ($models as $model) {
            if ($model->getYearInterval()->intersects($criteria->getYearInterval())) {
                $result [] = $model;
            }
        }
        // mai exista si alte filtrari
        return $result;
    }

    // http://world.std.com/~swmcd/steven/tech/interval.html
}

class X
{
    function f()
    {
        $x = (new Interval(1, 3))->intersects(new Interval(2, 4));
    }
}

#Embedded
class Interval
{
    private int $start;
    private int $end;

    public function __construct(int $start, int $end)
    {
        if ($start > $end) {
            throw new \Exception();
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

class MathUtil
{ // aka Garbage

}


class CarSearchCriteria
{
    private Interval $yearInterval;

    public function __construct($yearInterval)
    {
        $this->yearInterval = $yearInterval;
    }


    public function getYearInterval(): Interval
    {
        return $this->yearInterval;
    }
}


#Entity
class CarModel
{
    private $make;
    private $model;
    #Embeddable
    private Interval $yearInterval;

    public function __construct(Interval $yearInterval, string $model, string $make)
    {
        $this->yearInterval = $yearInterval;
        $this->model = $model;
        $this->make = $make;
    }

    /**
     * @param string $make
     */
    public function setMake(string $make): void
    {
        $this->make = $make;
    }

    /**
     * @param Interval $yearInterval
     */
    public function setYearInterval(Interval $yearInterval): void
    {
        $this->yearInterval = $yearInterval;
    }

    public function getYearInterval(): Interval
    {
        return $this->yearInterval;
    }
}