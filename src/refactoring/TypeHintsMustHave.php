<?php


namespace victor\refactoring;


class TypeHintsMustHave
{
    private A $a;

    public function __construct(A $a)
    {
        $this->a = $a;
    }

    function b(A $a)
    {
        $a->laLibe();
        $this->getA()->laLibe();
    }
    function getA():A {
        return new A();
    }

}
class Doi
{
    function functieOK(A $a)
    {
        $a->laLibe();
    }
}

class A
{
    function laLibe()
    {

    }
}