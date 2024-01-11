<?php


namespace victor\clean;


class GuardClauses
{
    private $isSeparated = false;
    private $isRetired = false;

    function getPayAmount()
    {
        if ($this->determineIfDead()) { // early return = guard clauses
//            throw // fail fast
            return $this->deadAmount();
        }
        if ($this->isSeparated) {
            return $this->separatedAmount();
        }
        if ($this->isRetired) {
            return $this->retiredAmount();
        }
        $pay = 1;
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        $result = $pay;


        return $result;
    }

    private function deadAmount()
    {
        return 1;
    }

    private function retiredAmount()
    {
        return 2;
    }

    private function separatedAmount()
    {
        return 3;
    }

    private function normalPayAmount()
    {
        return 4;
    }

    private function determineIfDead()
    {
        return true;
    }

}

//
//foreach (null as $item) {
//    echo "wtf";
//}