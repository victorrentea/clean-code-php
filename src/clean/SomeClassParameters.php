<?php


namespace victor\refactoring;

$some = new SomeClassParameters();
$some->bigUglyMethod(1, 2);
$some->bigUglyMethod(1, 2);
$some->bigUglyMethod(1, 2);
$some->bigUglyMethod(1, 2);
$some->bigUglyMethod(1, 2);

// TODO From my use-case 323, I call it too, to do more within:
$some->bigUglyMethod323(1, 2);

class SomeClassParameters
{

	function bigUglyMethod(int $a, int $b) {
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";
        $this->end($a, $b);
    }

	function bigUglyMethod323(int $a, int $b) {
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";
        echo "Extra logic just for uc323";
        echo "Extra logic2 just for uc323";
        $this->end($a, $b);
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

    public function end(int $a, int $b): void
    {
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $b\n";
    }
}
