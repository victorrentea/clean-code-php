<?php


namespace victor\refactoring;


class GuardClauses
{
    private $isDead = false;
    private $isSeparated = false;
    private $isRetired = false;

    function getPayAmount()
    {
//        if ($this->determineIfItsDead1Second()) { // REST
//            return $this->deadAmount();
//        }
        if ($this->determineIsSeparated50ms() /*&& ! $this->compute2ms()*/) { // DB  [7 or 15]
            return $this->separatedAmount();
        }
        if ($this->compute2ms()) { // CPU returns 95%    95*2/100 = X   [7]
            return $this->separatedAmount();
        }
//        if ($this->isRetired) { // 0.1ms  returns 30%     30*0.2/100 = Y
//            return $this->retiredAmount();
//        }
        // MORE LOGIC
        // MORE LOGIC
        // MORE LOGIC
        // MORE LOGIC
        // MORE LOGIC
        // MORE LOGIC
        // MORE LOGIC
        // MORE LOGIC
        // MORE LOGIC
        // MORE LOGIC
        // MORE LOGIC
        // MORE LOGIC
        return $this->normalPayAmount();
    }

    private function deadAmount()
    {
        return 1;
    }

    private function separatedAmount()
    {
        return 3;
    }

    private function retiredAmount()
    {
        return 2;
    }

    private function normalPayAmount()
    {
        return 4;
    }

}