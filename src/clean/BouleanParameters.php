<?php


namespace victor\refactoring;

use function rand;
use function rand as rand1;

$boule = new BouleanParameters();
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);

// TODO From my use-case, I call it too, to do more within:
//$boule->bigUglyMethodCR322(1, 2);

$boule->bigUglyMethod456(1, 2);

class BouleanParameters
{

//    function bigUglyMethodCR322(int $a, int $b)
//    {
//        echo "Inainte al meu $a";
//
//        $this->bigUglyMethod($a, $b, false);
//        echo "Dupa al meu $a";
//    }

	function bigUglyMethod(int $a, int $b) {

        $i = 7 + rand(1, 5);
        $j = $this->before2($a, $b);

        $this->afterLogic($j, $a, $i, $b);
    }

	function bigUglyMethod456(int $a, int $b) {

        $i = 7 + rand(1, 5);
        $j = $this->before2($a, $b);

        echo "Doar al meu $a";

        $this->afterLogic($j, $a, $i, $b);
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

    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    private function before2(int $a, int $b): int
    {
        $j = 7 + rand(1, 5);
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";
        return $j;
    }

    /**
     * @param int $j
     * @param int $a
     * @param int $i
     * @param int $b
     */
    private function afterLogic(int $j, int $a, int $i, int $b): void
    {
        echo "More Complex $j Logic $a\n";
        echo "More Complex $i Logic $a\n";
        echo "More Complex Logic $b\n";
    }

    /**
     * @param int $j
     * @param int $a
     * @param int $i
     * @param int $b
     */


}
