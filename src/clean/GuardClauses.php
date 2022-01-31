<?php


namespace victor\clean;


class GuardClauses
{
    private $isSeparated = false;
    private $isRetired = false;

    function getPayAmount()
    {
        if ($this->determineIfDead()) {
            return $this->deadAmount();
        }
            if ($this->isSeparated) {
               return $this->separatedAmount();
            }
        if (!$this->isRetired) {
            $pay = 1;
            // 20 lines of complex logic
            // 20 lines of complex logic
            // 20 lines of complex logic
            // 20 lines of complex logic
            // 20 lines of complex logic
            $result = $pay;
        } else {
            $result = $this->retiredAmount();
        }
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