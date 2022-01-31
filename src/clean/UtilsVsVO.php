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
            if (MathUtil::intervalsIntersect(
                $carModel->getStartYear(), $carModel->getEndYear(),
                $criteria->getStartYear(), $criteria->getEndYear())) {

                $result [] = $carModel;
            }
        }
        return $result;
    }

    // http://world.std.com/~swmcd/steven/tech/interval.html
}


// class MathService { // nu-mi place ca ma gandesc  ca tre s-o iau injectata din symph
// class MathHelper {
class MathUtil {

    public static function intervalsIntersect(int $start1, int $end1, int $start2, int $end2): bool
    {
        return $start1 <= $end2 && $start2 <= $end1;
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