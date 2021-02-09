<?php


namespace victor\clean;


class GuardClauses
{
    private $isSeparated = false;
    private $isRetired = false;

    function getPayAmount()
    {
        try {
            if ($this->determineIfDead()) {
                throw  new \Exception();
            }
            if ($this->isSeparated) {
                return $this->separatedAmount();
            }
            if ($this->isRetired) {
                return $this->retiredAmount();
            }
            return $this->doComputePay();
        } catch (\Exception $e) {
            //
        }
    }

    private function determineIfDead()
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

    /**
     * @return int
     */
    public function doComputePay(): int
    {
        $pay = 1;
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logic
        // 20 lines of complex logicpay

        // $pay += factori *
        $result = $pay;
        return $result;
    }

    private function normalPayAmount()
    {
        return 4;
    }

}