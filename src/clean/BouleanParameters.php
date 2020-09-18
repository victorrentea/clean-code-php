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

	function bigUglyMethod987(int $a, int $b) {
        echo "Extra logic before the method here";
        $this->bigUglyMethod();
    }
	function bigUglyMethod(int $a, int $b) {
        $this->beforeLogic();
        $this->afterLogic();
    }
	function bigUglyMethod323(int $a, int $b) {
        $this->beforeLogic();
        echo "My custom logic here, only when I call the functin\n";
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
