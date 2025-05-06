<?php
@ini_set('memory_limit',1024*1024*1024);

class emp
{
    public function __construct(public int $salary, public int $age)
    {
    }

}

// Initialize the employees array
$employees = [];
// Add 10,000,000 employees with random age and salary
for ($i = 0; $i < 10000000; $i++) {
    $employees[] = new emp(rand(30000, 100000), rand(20, 60));
}

echo "Starting calculation";

// Calculate total salary using a foreach loop
$startTime = microtime(true);
$totalSalary = 0;
$totalAge = 0;
foreach ($employees as $employee) {
    $totalSalary += $employee->salary;
}
$endTime = microtime(true);
$foreachTime = $endTime - $startTime;

// Calculate total age using a for loop
$startTime = microtime(true);
foreach ($employees as $employee) {
    $totalAge += $employee->age;
}
$endTime = microtime(true);
$foreachTime = $endTime - $startTime;

// Output the results
echo "Total Salary: $totalSalary\n";
echo "Total Age: $totalAge\n";
echo "Time taken by foreach loop for total salary: {$foreachTime} seconds\n";
echo "Time taken by foreach loop for total age: {$foreachTime} seconds\n";