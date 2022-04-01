<?php


namespace victor\refactoring;

$boule = new BouleanParameters();
$boule->placeOrder(1, 2);
$boule->placeOrder(1, 2);
$boule->placeOrder(1, 2);
$boule->placeOrder(1, 2);
$boule->placeOrder(1, 2);

// in bucata ta
// TODO From my use-case, I call it too, to do more within:
$boule->placeOrder323(1, 2);


class BouleanParameters
{

    function placeOrder(int $a, int $b)
    {
        $this->placeOrderStart($a, $b);
        $this->placeOrderEnd($a, $b);
    }

    private function placeOrderStart(int $a, int $b): void
    {
        echo "Complex Logic with $a\n";
        echo "Complex Logic $b\n";
        echo "Complex Logic $a\n";
    }


    // ============== "BOSS" LEVEL: A lot harder to break down =================

    private function placeOrderEnd(int $a, int $b): void
    {
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $a\n";
        echo "More Complex Logic $b\n";
    }

    function placeOrder323(int $a, int $b)
    {
        $this->placeOrderStart($a, $b);
        echo "Logica mea !\n";
        $this->placeOrderEnd($a, $b);
    }


    function bossLevelStuffFluff(array $tasks)
    {
        $task = $this->bossStart($tasks);
        $this->bossEnd($tasks);
    }
    function bossLevelStuffFluff323(array $tasks)
    {
        $task = $this->bossStart($tasks);
        foreach ($tasks as $task) {
            echo "Treaba mea " . $task;
        }
        $this->bossEnd($tasks);
    }



    function bossLevelStuffNoFluff()
    {
        echo "Logic1\n";
        echo "Logic2\n";
        echo "Logic7\n";
    }
    function bossLevelNoStuff()
    {
        echo "Logic1\n";
        echo "Logic7\n";
    }

    private function bossStart(array $tasks): mixed
    {
        echo "Logic1\n";
        echo "Logic2\n";
        echo "Logic3\n";
        // $list = new Collection();
        // $list->map(t => t.id)
        $ids = [];
        foreach ($tasks as $task) {
            $ids[]=$task->id;
        }
        // $ids = $tasks.map(t=>t.id);
        echo "Logic4 " . $ids . "\n";
        return $task;
    }

    private function bossEnd(array $tasks): void
    {
        $i = 0;
        foreach ($tasks as $task) {
            $i++;
            echo "Logic5 " . $i . "\n";
        }
        $j = 1;
        echo "Logic6 " . ($j++) . "\n";
        echo "Logic7\n";
    }
}

(new BouleanParameters())->bossLevelNoStuff();
(new BouleanParameters())->bossLevelStuffNoFluff();
(new BouleanParameters())->bossLevelNoStuff();
(new BouleanParameters())->bossLevelStuffFluff([]);


class A
{
    private string $s;

    public function nuvamergealtfel()
    {

    }
}


function pros(A $a)
{
    $a->nuvamergealtfel();
}
















