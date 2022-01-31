<?php


namespace victor\refactoring;



class Immutable
{
    private X $x;
    private int $y;
    /** @var string[] */
    private array $strings;

    public function __construct(X $x, int $y, array $strings)
    {
        $this->x = $x;
        $this->y = $y;
        $this->strings = $strings;
    }
    public function withY(int $newY): Immutable { // witheri
        return  new Immutable($this->getX(), $newY, $this->getStrings());
    }

    public function getStrings(): array
    {
        return $this->strings;
    }
    public function getX(): X
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }
}
class X {
    private int $z;

    public function __construct(int $z)
    {
        $this->z = $z;
    }

    public function getZ(): int
    {
        return $this->z;
    }

}

$immutable = new Immutable(new X(999),2, ["a"]);


// copy-on-write arrays
var_dump($immutable->getStrings()); // NU ALOCA array daca doar citesti
$immutable->getStrings()[] = "b"; // ALOCA doar daca modifici orice cheie/elem

// daca ai putea face asta, obiectul tau nu ar fi DEEPLY IMMUTABLE ci doar superficial imutabil
// $immutable->getX()->z = -1; // cand intorci obiecte, sunt intoarse dupa referinta : primesti "pointer" la acelasi obiect initial alocat.
/**
 * @param Immutable $immutable
 * @return void
 */
function f(Immutable $immutable): void
{
// $immutable2 = new Immutable($immutable->getX(), 9, $immutable->getStrings());
    g($immutable);
}

/**
 * @param Immutable $immutable
 * @return void
 */
function g(Immutable $immutable): void
{
    $immutable2 = $immutable->withY(9);

    var_dump($immutable2);
}

f($immutable);

