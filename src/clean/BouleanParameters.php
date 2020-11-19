<?php


namespace victor\refactoring;

use function rand;

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

    function bigUglyMethod(int $a, int $b)
    {

        $i = 7 + rand(1, 5);
        $j = $this->before2($a, $b);

        $this->afterLogic($j, $a, $i, $b);
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


    // ============== "BOSS" LEVEL: A lot harder to break down =================

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

    function bigUglyMethod456(int $a, int $b)
    {

        $i = 7 + rand(1, 5);
        $j = $this->before2($a, $b);

        echo "Doar al meu $a";

        $this->afterLogic($j, $a, $i, $b);
    }

    function bossLevel(array $tasks, bool $toteu)
    {

        echo "Logic3\n";
        foreach ($tasks as $task) {
            $i++;
            echo "Logic4 " . $task . "\n";

            // TODO HERE, when call this method, I want MY own custom code to run here
            if ($toteu) {
                echo "Custom logic $i"; //
            }
            echo "Logic5 " . $i . "\n";
        }


        echo "Logic6 " . "\n";
    }



    function bossLevelsparta(array $tasks, bool $toteu)
    {
        // Split Loop refactor:
        // TODO: cand e bug sa sparg forul
            // evit daca nu inteleg: e mult mai periculos sa spargi un for decat un if

        // TODO: cand nu e indicat sa sparg forul?
            // cand sunt multe date: milioane -> ce cauti cu ele in memorie!?
            // CAZ VALID: aduci in pagini de pe remote si procezi pagina cu pagina. > trebuie un for

        while(!done) {

            $page= apiCall();

            $this->validateRecords($page);

            $transformed = transform($page);

            persist($transformed);
        }

        $resp = [];
        for () {

            $resp []= apiCall();
        }
        $dateDePeRemote = call();

        $dateDePeRemote
        $i = 0;
        echo "Logic3\n";
        foreach ($tasks as $task) {
            $i++;
            echo "Logic4 " . $task . "\n";
        }

        foreach ($tasks as $task) {
            // TODO HERE, when call this method, I want MY own custom code to run here
            if ($toteu) {
                echo "Custom logic $i";
            }
        }
        foreach ($tasks as $task) {

            echo "Logic5 " . $i . "\n";
        }
        echo "Logic6 " . "\n";
    }

    private function validateRecords($page) // 500 elemente
    {
        foreach ($page as $record) {

        }
        foreach ($page as $record) {

        }
        foreach ($page as $record) {

        }
        foreach ($page as $record) {

        }
    }

    /**
     * @param int $j
     * @param int $a
     * @param int $i
     * @param int $b
     */


}
