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

	function bigUglyMethod(int $a, int $b) {
        $this->logicStart($a, $b);
        $this->logicEnd($a, $b);
    }

	function bigUglyMethodCR323(int $a, int $b) {
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

    function bossLevel(bool $stuff, bool $fluff, array $tasks/*, callable $f*/) {
        $i = 0;
		$j = 1;
		echo "Logic1\n";
		if (!$stuff) {
            echo "Logic7()\n";
            return;
        }
        echo "Logic2\n";
        if (!$fluff) {
            echo "Logic7()\n";
            return;
        }
        echo "Logic3\n";

        foreach ($tasks as $task) {
            $i++;
            echo "Logic4 " . $task . "\n";
            // $f();
            if ($euOChem) {
                echo "Logica mea\n";
            }
            echo "Logic5 " . $i . "\n";
        }
        // for for for
        echo "Logic6 " . ($j++) . "\n";
        echo "Logic7()\n";
	}
}

// global $x = "de asta pleaca devii din PHP";

// supervariabila
// class OClasa {

//     private bool $cr323 = false;
//
//     public function setEuOChem(bool $cr323): void
//     {
//         $this->euOChem = $cr323;
//     }
//     function bossLevel(bool $stuff, bool $fluff, array $tasks) {
//         $i = 0;
//         $j = 1;
//         echo "Logic1\n";
//         if (!$stuff) {
//             echo "Logic7()\n";
//             return;
//         }
//         echo "Logic2\n";
//         if (!$fluff) {
//             echo "Logic7()\n";
//             return;
//         }
//         echo "Logic3\n";
//
//         foreach ($tasks as $task) {
//             $i++;
//             echo "Logic4 " . $task . "\n";
//             if ($cr323) {
//                 echo "Logica mea\n";
//             }
//             echo "Logic5 " . $i . "\n";
//         }
//         echo "Logic6 " . ($j++) . "\n";
//         echo "Logic7()\n";
//     }
// }
//
// interface OInterfata
// {
//     function bossLevel(bool $stuff, bool $fluff, array $tasks);
// }
//
// class Object1 implements OInterfata {
//
// }