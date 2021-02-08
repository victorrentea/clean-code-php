<?php


namespace victor\refactoring;


class TypeHintsMustHave
{
    private A $a;

    public function __construct(A $a)
    {
        $this->a = $a;
    }

    function observeModel(callable $f) {

    }

    #Inject
    function b(A $a)
    {
        $this->observeModel([$a, "laLiber2"]); // Storm stie

        $a->laLiber2();
        $s = "laLibe";
        $a->$s; // KO pt Storm
        $this->getA()->laLiber2();
    }
    function getA():A {
        return new A();
    }

}
class Doi
{
    function functieOK(A $a)
    {
        $a->laLiber2();
    }
}

class A
{
    function laLiber2()
    {

    }
}

class A2
{
    function laLibe()
    {

    }
}