<?php


namespace victor\refactoring;


class InlineFunction
{
    function getRating($driver): int {
        return $driver->numberOfLateDeliveries > 5 ? 2 : 1;
    }
    function getRating2($driver): int {
        return $driver->numberOfLateDeliveries > 5 ? 2 : 1;
    }
    function getRating42($driver): int {
        return $driver->numberOfLateDeliveries > 5 ? 2 : 1;
    }
    function getRating3($driver): int {
        return $driver->numberOfLateDeliveries > 5 ? 2 : 1;
    }

}