<?php


namespace victor\refactoring;


$boule = new BouleanParameters();
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);
$boule->bigUglyMethod(1, 2);

// TODO EU din  my use-case CR323, I call it too, to do more within:
$boule->bigUglyMethodDocker(1, 2);

class BouleanParameters
{

	function bigUglyMethod(int $ip, int $dnsNameCount) {
        $money = $this->initPyWorker($ip, $dnsNameCount);
        $this->audit($ip, $dnsNameCount, $money);
    }

	function bigUglyMethodDocker(int $ip, int $dnsNameCount) {
        $money = $this->initPyWorker($ip, $dnsNameCount);

        echo "Ceva doar pentru CR323";
        echo "Ceva doar pentru CR323";
        echo "Ceva doar pentru CR323";
        echo "Ceva doar pentru CR323";
        echo "Ceva doar pentru CR323";
        echo "Ceva doar pentru CR323";

        $this->audit($ip, $dnsNameCount, $money);
    }

    private function audit(int $ip, int $dnsNameCount, int $money)
    {
        echo "More Complex Logic $ip\n";
        echo "More Complex Logic $ip\n";
        echo "More Complex Logic $dnsNameCount\n $money";
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
     * @param int $ip
     * @param int $dnsNameCount
     * @return int
     */
    public function initPyWorker(int $ip, int $dnsNameCount): int
    {
        echo "Complex Logic with $ip\n";
        echo "Complex Logic $dnsNameCount\n";
        echo "Complex Logic $ip\n";
        $money = 1;
        return $money;
    }
}
