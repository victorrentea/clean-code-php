<?php


namespace victor\clean;


class GuardClauses
{
    private $isSeparated = false;
    private $isRetired = false;

    function getPayAmount(): int
    {
        if (!$this->determineIfDead()) { // network call
            if (!$this->isSeparated) {
                if (!$this->isRetired) {
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
                }
                else {
                    $result = $this->retiredAmount();
                }
            }
            else $result = $this->separatedAmount();
        }
        else {
            // 1 more line here

            $result = $this->deadAmount();
        }
        return $result;
    }

    private function deadAmount(): int
    {
        return 1;
    }

    private function retiredAmount(): int
    {
        return 2;
    }

    private function separatedAmount(): int
    {
        return 3;
    }

    private function normalPayAmount(): int
    {
        return 4;
    }

    private function determineIfDead(): bool
    {
        return true;
    }

}