<?php


namespace victor\refactoring;

$boule = new BouleanParameters();
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);

// TODO From my use-case CR323, I call it too, to do more within:
$boule->bigUglyMethod323(1, 2);

// $boule->setCr324(true);
// $boule->bossLevel(...);

class BouleanParameters
{


    // EVITA pe cat posibil sa faci clasele de logica stateful.
    // private $cr324;
    //
    // public function setCr324(bool $cr324): void
    // {
    //     $this->cr324 = $cr324;
    // }

    function bigUglyMethod(int $a, int $b) {
        $this->m($a,$b);
        $this->afterLogic($a, $b);
    }

	function bigUglyMethod323(int $a, int $b) {
        $this->m($a, $b);
        echo "Logica doar pentru mine Cr323 $a\n";
        $this->afterLogic($a, $b);
    }









	// ============== "BOSS" LEVEL: A lot harder to break down =================

	function bossLevelStuffFluff(array $tasks) {
        $this->beforeBoss($tasks);
        $this->afterBoss($tasks);
    }
	function bossLevelStuffFluff323(array $tasks) {
        $this->beforeBoss($tasks);

        $i = 0;
        foreach ($tasks as $task) {
            $i++;
            echo "Logica mea " . $i . "\n";
        }

        $this->afterBoss($tasks);
    }
	function bossLevelStuffNoFluff() {
		echo "Logic1\n";
        echo "Logic2\n";
		echo "Logic7\n";
	}
	function bossLevelNoStuf() {
		echo "Logic1\n";
		echo "Logic7\n";
	}












	///==================

    public function m(int $a, int $b): void
    {
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";
    }

    public function afterLogic(int $a, int $b): void
    {
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $b\n";
    }

    /**
     * @param array $tasks
     */
    public function beforeBoss(array $tasks): void
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
    public function afterBoss(array $tasks): void
    {
        $j = 0;
        foreach ($tasks as $task) {
            $j++;
            echo "Logic5 " . $j . "\n";
        }
        echo "Logic6 " . 3 . "\n";
        echo "Logic7\n";
    }
}
