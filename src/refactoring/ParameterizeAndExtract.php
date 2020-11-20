<?php


namespace victor\refactoring;

class ParameterizeAndExtract {

    function f() {
        echo "Logica f\n";

        $n = 4444;
        for ($i = 0; $i < $n; $i++) {
            echo "Cod $i\n";
        }
    }
    function g() {
        echo "Logica g\n";

        $n = 3;
        for ($i = 0; $i < $n; $i++) {
            echo "Cod $i\n";
        }
    }

}