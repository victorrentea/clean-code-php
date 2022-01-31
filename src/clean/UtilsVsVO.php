<?php


namespace victor\clean;


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
            $modelInterval = new Interval($carModel->getStartYear(), $carModel->getEndYear());

            if (MathUtil::intervalsIntersect($modelInterval, $criteriaInterval)) {
                $result [] = $carModel;
            }
        }
        return $result;
    }

    // http://world.std.com/~swmcd/steven/tech/interval.html
}
echo MathUtil::intervalsIntersect(new Interval(1, 3), new Interval(2, 4));

// class MathService { // nu-mi place ca ma gandesc  ca tre s-o iau injectata din symph
// class MathHelper {
class MathUtil {

    public static function intervalsIntersect(Interval $interval1, Interval $interval2): bool {
        return $interval1->getStart() <= $interval2->getEnd() && $interval2->getStart() <= $interval1->getEnd();
    }
}

class Interval {
    private int $start;
    private int $end;

    public function __construct(int $start, int $end)
    {
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