<?php


namespace victor\clean;


class GuardClauses
{
    private $isSeparated = false;
    private $isRetired = false;

    /**
     * this public method should be called for....
     * @return int
     * @throws \Exception
     */
    function getPayAmount()
    {
        if ($this->determineIfDead()) { // guard
            return $this->deadAmount();
        }

        // as per REG-151-115612
        if ($this->isSeparated) throw new \Exception("Yada yada");

        if ($this->isRetired) {
            return $this->retiredAmount();
        }

        $pay = 1;
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