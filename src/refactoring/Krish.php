<?php

namespace victor\refactoring;

class Krish
{
    public function __construct( // DI
//        private A $a // if you need exactly A
//        private I $i, // if you need A or B, later configured via symphony yaml
//        private array $allI // then tell DI to inject all implems of I = "chain of responsiblility" pattern
        private array $factory // decides based on custom logic whihch I to use
    )
    {}

    function f(RequestInterface $request)
    {
//        $this->factory->selectImpl($request)->doSomething(); // i'm passing to much data. what from the request is really used to decide
        $this->factory->selectImpl(ContinentResolver::getContinenet($request))->doSomething();
    }
}

interface I {
    function doSomething();
}
class A implements I{
    function doSomething(){}
}
class B implements I{
    function doSomething(){}
}
