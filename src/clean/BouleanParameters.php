<?php


namespace victor\refactoring;

$boolean = new BouleanParameters();
$boolean->bigUglyMethod(1, 2, false);
$boolean->bigUglyMethod(1, 2, false);
$boolean->bigUglyMethod(1, 2, false);
$boolean->bigUglyMethod(1, 2);
$boolean->bigUglyMethod(1, 2, false);

// TODO CR323 From my use-case, I call it too, to do more within:
$boolean->bigUglyMethod323(1, 2, true);
(new Alta())->met($boolean);

// (new Alta())->met(null); nu e clean code:

class Alta
{
    function met(BouleanParameters $o)
    {
        // if ($o)
        $o->bigUglyMethod(1, 7, false);
    }
}

class BouleanParameters
{

    function bigUglyMethodDefault(int $a, int $b)
    {
        $this->bigUglyMethod($a, $b, false);
    }

    function bigUglyMethod(int $a, int $b, bool $cr323 = false)
    {
        $this->beforeLogic($a, $b);
        $this->afterLogic($a, $b);
    }

    /**
     * @param int $a
     * @param int $b
     */
    private function beforeLogic(int $a, int $b): void
    {
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";

        // check unique customer
        $this->checkUniqueCustomer($a, $b);

        $this->registerCustomer($a, $b);
    }


    // ============== "BOSS" LEVEL: A lot harder to break down =================

    /**
     * Notifies 3rd party systems.
     */
    private function checkUniqueCustomer(int $a, int $b): void
    {
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex LogicX $a\n";

        echo "Complex Logic with $a\n";
        echo "ComplexV Logic $b\n";
        echo "Complex Logic $a\n";
        echo "ComplexE Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";
    }

    /**
     * @param int $a
     * @param int $b
     */
    private function registerCustomer(int $a, int $b): void
    {
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";
    }

    /**
     * @param int $a
     * @param int $b
     */
    private function afterLogic(int $a, int $b): void
    {
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $b\n";
    }

    function bigUglyMethod323(int $a, int $b, bool $cr323 = false)
    {

        $this->beforeLogic($a, $b);
        $this->doCevaNou();
        $this->afterLogic($a, $b);
    }

    private function doCevaNou(): void
    {
        echo "Si logica asta !\n";
    }

    function bossLevelStuffFluff(array $tasks)
    {
        $this->bossStart($tasks);
        $this->bossEnd($tasks);
    }
    function bossLevelStuffFluff323(array $tasks)
    {
        $this->bossStart($tasks);
        foreach ($tasks as $task) {
            // TODO HERE, when call this method, I want MY own custom code to run here
            echo "Codu meu\n";
        }
        $this->bossEnd($tasks);
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

    /**
     * @param array $tasks
     */
    private function bossStart(array $tasks): void
    {
        echo "Logic1\n";
        echo "Logic2\n";
        echo "Logic3\n";
        foreach ($tasks as $task) {
            echo "Logic4 " . $task . "\n";
        }
    }

    /**
     * @param array $tasks
     */
    private function bossEnd(array $tasks): void
    {
        $i = 0;
        foreach ($tasks as $task) {
            $i++;
            echo "Logic5 " . $i . "\n";
        }
        $j = 1;
        echo "Logic6 " . ($j++) . "\n";
        echo "Logic7\n";
    }
}
