<?php


namespace victor\refactoring;

$obiect = new BouleanParameters();
$obiect->bigUglyMethod(1, 2);
$obiect->bigUglyMethod(1, 2);
$obiect->bigUglyMethod(1, 2);
$obiect->bigUglyMethod(1, 2);
$obiect->bigUglyMethod(1, 2);

// horror($obiect);
// problemaComuna($obiect);

// NICIODATA SUB NICI O SCUZA IN LOGICA CENTRALA
function horror($obiect) {
    $meth = "bigUglyMethod"; //
    $obiect->$meth();
}
// numele functiei indicat intr-un services.yaml sau in DB  : 'bigUglyMethod"

function problemaComuna(BouleanParameters $obiect):void { // lipsesct typehints
    $obiect->bigUglyMethod();
}


// TODO From my use-case, I call it too, to do more within: CR323
$obiect->bigUglyMethodCR323(1, 2);

class BouleanParameters
{

    function bigUglyMethod(int $a, int $b)
    {
        $this->logicStart($a, $b);
        $this->logicEnd($a, $b);
    }

    function bigUglyMethodCR323(int $a, int $b)
    {
        $this->logicStart($a, $b);
        echo "LOgica de-a ta FIX AICI IN ACEST LOC\n";
        $this->logicEnd($a, $b);
    }

    private function logicStart(int $a, int $b): void
    {
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";
    }

    private function logicEnd(int $a, int $b): void
    {
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $b\n";
    }


    // ============== "BOSS" LEVEL: A lot harder to break down =================


    function bossLevelStuffFluff323(array $tasks) {
        $this->bossStart($tasks);

        foreach ($tasks as $task) {
            echo "Doar al meu pe cr323\n";
        }
        $this->bossEnd($tasks);
    }
    function bossLevelStuffFluff(array $tasks) {
        $this->bossStart($tasks);
        $this->bossEnd($tasks);
    }
    function bossLevelStuffNoFluff() {
        echo "Logic1\n";
        echo "Logic2\n";
        echo "Logic7\n";
    }
    function bossLevelNoStuff() {
        echo "Logic1\n";
        echo "Logic7\n";
    }

    private function bossStart(array $tasks): void
    {
        echo "Logic1\n";
        echo "Logic2\n";
        echo "Logic3\n";
        foreach ($tasks as $task1) {
            echo "Logic4 " . $task1 . "\n";
        }
    }

    private function bossEnd(array $tasks): void
    {
        $i = 0;
        foreach ($tasks as $task) {
            $i++;
            echo "Logic5 " . $i . "\n";
        }
        $j = 1;
        // ATENTIE! daca MUSAI trebuie rulat Logic4 urmat de Logic5 pt acelasi task, atunci NU SPARGE FORUL > BUGURI
        echo "Logic6 " . ($j++) . "\n";
        echo "Logic7\n";
    }

}

// emag, acum 6 ani:
// "noi folosi structuri array nu tipuri"
// array si nu Person:
// Victor (PANICAT) cum adica !?
// Da, ca e mai eficient.
// Victor (PANICAT) cum adica !?
// E mai rapid.
// Victor (PANICAT) cum adica !?
// La runtime.
// Coleg PHP 7 > BA NU. nu mai e

$ar = [
    "campu1"=>1,
    "campu2"=>"Mama",

];

function f(array $a) {
}