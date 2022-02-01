<?php


namespace victor\refactoring;

class ParameterizeAndExtract {

    function f() {
        echo "Logica f\n";

        $this->commonPart(4);
    }
    function g() {
        echo "Logica g\n";

        $this->commonPart(3);
    }

    private function commonPart(int $n): void
    {
        for ($i = 0; $i < $n; $i++) {
            echo "Cod $i\n";
        }
    }

}