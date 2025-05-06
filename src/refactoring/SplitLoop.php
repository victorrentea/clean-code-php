<?php


namespace victor\refactoring;
class X {

}
class SplitLoop {
    /** @param Employee[] $employees */
    static function computeStats(array $employees) {
        $averageAge = new SplitLoop()->computeAverageAge($employees);
        $averageSalary = self::computeAverageSalary($employees);
        // repeating a for loop will NOT produce performance issues.
        // a) collection is small => overhead = minimal
        // b) collection is large => Q: where did that collection come from?
        //  > API call (Fb) ~50-200ms...
        //  > SQL (SELECT)~1-10ms
        //  > Redis (<1ms response)
        // if you bring over the network,  the overehad of that NETWORK
        // CALL WILL GREATLY OUTWEIGH the potential loss of performance
        echo "avg age = $averageAge\navg sal = $averageSalary\n";
    }

    private function internal() {
        $var = 1;
    }
    /**
     * @param array $employees
     * @return float|int
     */
    public static function computeAverageSalary(array $employees): int|float
    {
        $totalSalary = 0;
        foreach ($employees as $e) {
            $totalSalary += $e->salary;
        }
        // less efficient due to creating the intermediate array
//        $totalSalary=array_sum(array_column($employees, 'salary'));
        $averageSalary = $totalSalary / sizeof($employees);
        return $averageSalary;
    }

    public function computeAverageAge(array $employees): int|float
    {
        // imperative style = OK
//        $totalAge = 0;
//        foreach ($employees as $e) {
//            $totalAge += $e->age;
//        }
//        return $totalAge / sizeof($employees);

        // FP style = OK
//        return array_sum(array_map($employees, fn($emp)=>$emp->age)) / sizeof($employees);

//        $totalAge = 0;
//        array_walk($employees, function ($emp) use (&$totalAge) {
//            $totalAge += $emp->age; // DATA MUTATION in a Functional-Style code
//            // don't change data in callbacks
//        }); // WRONG !!!
//        return $totalAge / sizeof($employees);

        array_walk($employees, function ($emp)  {
            $this->totalAge += $emp->age; // DATA MUTATION in a Functional-Style code
            // don't change data in callbacks
        }); // WRONG !!!
        return $this->totalAge / sizeof($employees);
    }
    // Temporary field, one of the worst species
    private int $totalAge = 0; // WRONG!!! WORST!! escalating state to longer-lived just to be able to change it

}


SplitLoop::computeStats([new Employee(24, 1500), new Employee(30, 2500)]);


class Employee {
    public $age;
    public $salary;

    public function __construct(int $age, float $salary)
    {
        $this->age = $age;
        $this->salary = $salary;
    }
}
