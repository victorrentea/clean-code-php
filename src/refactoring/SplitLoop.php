<?php


namespace victor\refactoring;

class SplitLoop {
    /** @param Employee[] $employees */
    static function computeStats(array $employees) {
        $totalAge = 0;
        foreach ($employees as $e) {
            $totalAge += $e->age;
        }

        $totalSalary = 0;
        foreach ($employees as $e) {
            $totalSalary += $e->salary;
        }
        // repeating a for loop will NOT produce performance issues.
        // a) collection is small => overhead = minimal
        // b) collection is large => Q: where did that collection come from?
        //  > API call (Fb) ~50-200ms...
        //  > SQL (SELECT)~1-10ms
        //  > Redis (<1ms response)
        // if you bring over the network,  the overehad of that NETWORK
        // CALL WILL GREATLY OUTWEIGH the potential loss of performance
        $averageAge = $totalAge / sizeof($employees);
        $averageSalary = $totalSalary / sizeof($employees);
        echo "avg age = $averageAge\navg sal = $averageSalary\n";
    }
}
//        $averageAge = array_average($employees, fn($emp)=>$emp->salary) // high cost

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
