<?php

namespace victor\refactoring;

class RefactoringWarmup {
    public static function main(): void {
        $two = new Two();
        echo new One($two)->f() . PHP_EOL;
        echo $two->g(new R(1)) . PHP_EOL;
    }
}

class One {
    public function __construct(
        private readonly Two $two
    ) {}

    public function f(): int {
        return 2 * $this->two->g(new R(3));
    }
}

class Two {
    public function g(R $r): int {
        $b = 2;
        $this->getStr($b, $r->x());
        return 1 + $b + $r->x();
    }

    public function getStr(int $b, int $x): void
    {
        echo $x . "b=$b\n" . PHP_EOL;
    }
}

class R {
    public function __construct(
        private int $x
    ) {}

    public function x(): int {
        return $this->x;
    }
}

RefactoringWarmup::main();