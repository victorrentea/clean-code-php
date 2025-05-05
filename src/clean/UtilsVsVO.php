<?php


namespace victor\clean;


class UtilsVsVO
{
    /**
     * @param CarModel[] $models
     * @return CarModel[]
     */
    public function filterCarModels(CarSearchCriteria $criteria, array $models)
    {
        $result = [];
        foreach ($models as $model) {
            if (MathUtil::intervalsIntersect(
                new Interval($model->getStartYear(), $model->getEndYear()),
                new Interval($criteria->getStartYear(), $criteria->getEndYear()))) {

                $result [] = $model;
            }
        }
        return $result;
    }


}

class MathUtil
{
    public static function intervalsIntersect(Interval $interval1, Interval $interval2): bool
    {
        return $interval1->getStart() <= $interval2->getEnd() && $interval2->getStart() <= $interval1->getEnd();
    }
}


// Value Object design pattern = 💖immutable object lacking PK
/**@Embeddable*/
public readonly class Interval{
    public function __construct(
        private int $start,
        private int $end
    )
    {}
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
}


class CarModel
{
    private $make;
    private $model;
    private $startYear;
    private $endYear;

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
