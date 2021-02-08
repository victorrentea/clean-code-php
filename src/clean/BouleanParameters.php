<?php


namespace victor\refactoring;

$boule = new BouleanParameters();
$boule->bigUglyMethod(1, 2, false);
$boule->bigUglyMethod(1, 2, false);
$boule->bigUglyMethod(1, 2, false);
$boule->bigUglyMethod(1, 2, false);
$boule->bigUglyMethod(1, 2, false);
$boule->bigUglyMethod(1, 2, false);

// TODO From my use-case CR323, I call it too, to do more within:
$boule->bigUglyMethod(1, 2, false);

class BouleanParameters
{

	function bigUglyMethod(int $a, int $b, bool $cr323) {
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";

        if ($cr323) {
            echo "Logica doar pentru mine Cr323 $a\n";
        }

        echo "More Complex Logic $a\n";
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $b\n";
    }











	// ============== "BOSS" LEVEL: A lot harder to break down =================

	function bossLevel(bool $stuff, bool $fluff, array $tasks) {
        $i = 0;
		$j = 1;
		echo "Logic1\n";
		if ($stuff) {
            echo "Logic2\n";
            if ($fluff) {
                echo "Logic3\n";
                foreach ($tasks as $task) {
                    $i++;
                    echo "Logic4 " . $task . "\n";
                    // TODO HERE, when call this method, I want MY own custom code to run here
                    echo "Logic5 " . $i . "\n";
                }
				echo "Logic6 " . ($j++) . "\n";
			}
		}
		echo "Logic7\n";
	}
}
