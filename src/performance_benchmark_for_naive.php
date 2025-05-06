<?php
@ini_set('memory_limit', '2G'); // or '4G'

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

echo "Start!!!!\n";


$startTime = microtime(true);
$totalSalary = 0;
$totalAge = 0;
foreach ($employees as $employee) {
    $totalSalary += $employee->salary;
    $totalAge += $employee->age;
}
$endTime = microtime(true);
$foreachTime = $endTime - $startTime;


// Calculate total salary using a foreach loop
$totalSalary = 0;
$startTime = microtime(true);
foreach ($employees as $employee) {
    $totalSalary += $employee->salary;
}
$endTime = microtime(true);
$foreachSalaryTime = $endTime - $startTime;

// Calculate total age using a for loop
$totalAge = 0;
$startTime = microtime(true);
foreach ($employees as $employee) {
    $totalAge += $employee->age;
}
$endTime = microtime(true);
$foreachAgeTime = $endTime - $startTime;

// Output the results
echo "Total Salary: $totalSalary\n";
echo "Total Age: $totalAge\n";
echo "foreach salary: {$foreachSalaryTime} seconds\n";
echo "foreach age: {$foreachAgeTime} seconds\n";


// Output the results
//echo "Total Salary: $totalSalary\n";
//echo "Total Age: $totalAge\n";
echo "foreach salary + age: {$foreachTime} seconds\n";

echo "Overhead of 1 foreach: " . ($foreachSalaryTime + $foreachAgeTime - $foreachTime) . " seconds\n";

// biases:
// - compare to time to download 10m employees from DB in prod-like env = Minutes?
// - run on a server CPU (much stronger? than your local computer)
// - warmup phase is missing: swapping the two experiments backwards renders different results
// - repeated measuring is missing: we have to run each for a number of times and average the measuring.