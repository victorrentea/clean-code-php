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
		echo "Logic1\n";
        echo "Logic2\n";
        echo "Logic3\n";
        $j = 0;
        $i = 0;
        foreach ($tasks as $task) {
            $i++;
            // modificari ale starii globale dpdv iteratia curenta,
            // care date sunt citite ulterior de celelalte foruri

            // externalSystem->authenticate(task->user)

            // INSERT INTO X

            $j++;
            echo "Logic4 " . $task . "\n";
        }
        foreach ($tasks as $task) {
            echo "Logica mea " . $i . "\n";
        }

        foreach ($tasks as $task) {
            // externalSystem->perfromSecuredTask(task)
            // SEELCT COUNT INTO X
            echo "Logic5 " . $i . "\n";
        }
        echo "Logic6 " . $j . "\n";
		echo "Logic7\n";
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
}
