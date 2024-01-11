<?php

namespace victor\refactoring;

$a = [1, 2];
testDeModifArr($a);
function testDeModifArr(array $arr)
{
    $arr[] = 3;
}


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

    function bigUglyMethod(int $ip, int $dnsNameCount)
    {
        $money = $this->initPyWorker($ip, $dnsNameCount);
        $this->audit($ip, $dnsNameCount, $money);
    }

    function bigUglyMethodDocker(int $ip, int $dnsNameCount)
    {
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
    function bossLevel(array $tasks)
    {
        $i = $this->ini($tasks);
        // TODO HERE, when call this method, I want MY own custom code to run here

        $this->disconnect($tasks);
    }
    function bossLevelDocker(array $tasks)
    {
        $i = $this->ini($tasks);

        foreach ($tasks as $task) {
            echo "Stuf";
        }
        // TODO HERE, when call this method, I want MY own custom code to run here

        $this->disconnect($tasks);
    }

    /**
     * @param string[] $phpECumE
     * @param int $ip the ip to scan for vulnerability. asa nu
     * @param int $dnsNameCount
     * @param Array<string> $phpECumE
     * @return int
     */
    public function initPyWorker(int $ip, int $dnsNameCount, array $phpECumE): int
    {
        echo "Complex Logic with $ip\n";
        echo "Complex Logic $dnsNameCount\n";
        echo "Complex Logic $ip\n";
        $money = 1;
        return $money;
    }

    /**
     * @param array $tasks
     * @return int|string
     */
    public function ini(array $tasks)
    {
        echo "Logic1\n";

        echo "Logic2\n";
        echo "Logic3\n";

        foreach ($tasks as $i => $task) {
            echo "Logic4 " . $task . "\n";
//            connectToWorker($task)
        }
        return $i;
    }

    /**
     * @param array $tasks
     * @return void
     */
    public function disconnect(array $tasks): void
    {
        foreach ($tasks as $i => $task) {
            echo "Logic5 " . ($i + 1) . "\n";
//            disconnectWorker($task);
        }

        $taskCount = count($tasks);
        echo "Logic6 $taskCount\n";
        echo "Logic7\n";
    }

    private function innocent(array &$tasks)
    {
        $tasks[] = "#sieu";
    }
}
