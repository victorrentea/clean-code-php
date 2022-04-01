<?php


namespace victor\refactoring;


class SeparateQueryCommand
{

    function alertForMiscreant(array $people): string
    {
        foreach ($people as $person) {
            if ($person === "Don") {
                $this->setOffAlarms();
                return "Don";
            }
            if ($person === "John") {
                $this->setOffAlarms();
                return "John";
            }
        }
        return "";
    }

    private function setOffAlarms()
    {
        echo "Side effects\n";
    }

}