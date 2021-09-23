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

echo "#sieu ". UtilsVsVO::intervalsIntersect(new Interval(2012, 2018), new Interval(2005, 2013)) . "\n";
echo "#sieu ". UtilsVsVO::intervalsIntersect(new Interval(2012, 2018), new Interval(2005, 2013)) . "\n";
echo "#sieu ". UtilsVsVO::intervalsIntersect(new Interval(2012, 2018), new Interval(2005, 2013)) . "\n";
echo "#sieu ". UtilsVsVO::intervalsIntersect(new Interval(2012, 2018), new Interval(2005, 2013)) . "\n";

class UtilsVsVO
{

    /**
     * @param CarModel[] $models
     */
    public function filterCarModels(CarSearchCriteria $criteria, array $models)
    {
        $result = [];
        foreach ($models as $model) {
            if (UtilsVsVO::intervalsIntersect(new Interval($model->getStartYear(), $model->getEndYear()), new Interval($criteria->getStartYear(), $criteria->getEndYear()))) {

                $result [] = $model;
            }
        }
        return $result;
    }

    public static function intervalsIntersect(Interval $interval1, Interval $interval2): bool
    {

        return $interval1->getStart() <= $interval2->getEnd() && $interval2->getStart() <= $interval1->getEnd();
    }
    // http://world.std.com/~swmcd/steven/tech/interval.html
}
class Interval {
    private int $start;
    private int $end;

    public function __construct(int $start, int $end)
    {
        $this->start = $start;
        $this->end = $end;
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

    public function getYearInterval()
    {
        return [$this->startYear, $this->endYear];
    }
}