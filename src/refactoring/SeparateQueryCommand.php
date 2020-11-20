<?php


namespace victor\refactoring;


class SeparateQueryCommand
{

    function alertForMiscreant(array $people): string
    {
        $result = $this->alertForMiscreant_($people);
        if ($result !== "") {
            $this->setOffAlarms();
        }
        return $result;
    }
    function alertForMiscreant_(array $people): string
    {
        foreach ($people as $person) {
            if (in_array($person, ["Don", "John"])) {
                return $person;
            }
        }
        return "";
    }

    private function setOffAlarms()
    {
        echo "Side effects\n";
    }

}