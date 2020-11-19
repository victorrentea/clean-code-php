<?php


namespace victor\refactoring;

$boule = new BouleanParameters();
$boule->bigUglyMethod(1, 2, false);
$boule->bigUglyMethod(1, 2, false);
$boule->bigUglyMethod(1, 2, false);
$boule->bigUglyMethod(1, 2, false);
$boule->bigUglyMethod(1, 2, false);

// TODO From my use-case, I call it too, to do more within:
$boule->bigUglyMethodCR322(1, 2);

$boule->bigUglyMethod(1, 2, true);

class BouleanParameters
{

    function bigUglyMethodCR322(int $a, int $b)
    {
        echo "Inainte al meu $a";
        $this->bigUglyMethod($a, $b, false);
        echo "Dupa al meu $a";
    }

	function bigUglyMethod(int $a, int $b, bool $cr456) {

        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";

        if ($cr456) {
            $this->bigUglyMethod($a, $b, $cr456);
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
