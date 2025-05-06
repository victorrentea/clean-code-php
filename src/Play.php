<?php
//
//
//class X {
//    function pred(int $n)
//    {
//        return $n % 2 == 0;
//    }
//    function f()
//    {
////        var_dump(array_filter([1, 2, 3], [$this, 'pred']));
////        var_dump(array_filter([1, 2, 3], !$this->pred())); // fails to run
////        var_dump(array_filter([1, 2, 3], fn($i) => !$this->pred($i))); // works
//
//        var_dump(array_filter([1, 2, 3], function ($i) {
//            return !$this->pred($i);
//        })); // works
//    }
//}
//new X()->f();
//

class R {
    public ?int $x;
}

echo new R()->x ?? null;


//$cn = Sthis->channelNumberResolver->resolveOrDefaultToNull($channel); // uses env config variables
//$cn = $channel->number ?? null;