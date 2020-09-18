<?php


namespace victor\refactoring;

$boule = new BouleanParameters();
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);

// TODO From my use-case, I call it too, to do more within:
$boule->bigUglyMethod323(1, 2);

// TODO From my use-case, I call it too, to do more within:
$boule->bigUglyMethod987(1, 2);

class BouleanParameters
{

    function bigUglyMethod987(int $a, int $b)
    {
        echo "Extra logic before the method here";
        $this->bigUglyMethod();
    }

    function bigUglyMethod(int $a, int $b)
    {
        $this->beforeLogic();
        $this->afterLogic();
    }

    private function beforeLogic(): void
    {
        echo "Complex Logic\n";
        echo "Complex Logic\n";
        echo "Complex Logic\n";
    }

    private function afterLogic(): void
    {
        echo "More Complex Logic\n";
        echo "More Complex Logic\n";
        echo "More Complex Logic\n";
    }

    function bigUglyMethod323(int $a, int $b)
    {
        $this->beforeLogic();
        echo "My custom logic here, only when I call the functin\n";
        $this->afterLogic();
    }


    // ============== "BOSS" LEVEL: A lot harder to break down =================

    function bossLevelStuffFluff(array $tasks)
    {
        echo "Logic1\n";
        echo "Logic2\n";
        echo "Logic3\n";
        $i = 0;
        foreach ($tasks as $task) {
            echo "Logic4 " . $task . "\n";

            // TODO HERE, when call this method, I want MY own custom code to run here

            echo "My Logic, that should run when I call this function\n";
            // $this->abstractStep(); // template method
            // $this->missingStep->call(); // composition of the behavior
            // $missingStep->call(); // passing an object to do stuff, not just the boolean


            $i++;
            echo "Logic5 " . $i . "\n";
        }
        echo "Logic6 " . 1 . "\n";
        echo "Logic7\n";
    }

    function bossLevelStuffNoFluff()
    {
        echo "Logic1\n";
        echo "Logic2\n";
        echo "Logic7\n";
    }

    function bossLevelNoStuff()
    {
        echo "Logic1\n";
        echo "Logic7\n";
    }

}
