<?php


namespace victor\clean;


class GuardClauses
{
    private $isSeparated = false;
    private $isRetired = false;

    // ------------

    function getPayAmount(?int $marineId) // cu cat sa platesc soldatii?
    {
        if ($this->determineIfDead($marineId)) { // network call 200 ms + blocheaza un thread
            return $this->deadAmount();
        }
        if ($marineId == null) {
            throw  new \Exception();
        }
        if ($this->isSeparated) {
            return $this->separatedAmount();
        }
        if ($this->isRetired) {
            return $this->retiredAmount();
        }

        return $this->coputeRegularAmount();
    }

    private function determineIfDead(int $marineId)
    {
        return true;
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

    /**
     * @return int
     */
    private function coputeRegularAmount(): int
    {
        $pay = 1;
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        $result = $pay;
        return $result;
    }

}