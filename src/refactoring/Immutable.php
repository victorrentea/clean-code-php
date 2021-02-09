<?php


namespace victor\refactoring;

$immutable = new Immutable(1, new Y(9),["Emagia"]);

var_dump($immutable->getList());

$immutable->getList()[]="a";
$immutable->getY()->setGandamStyle(10);

var_dump($immutable->getList());
// var_dump($immutable->getY()->getGandamStyle());

// f($immutable);
$arr = [];
fff($arr);
var_dump("aaa", $arr);

function fff (array &$a) {
    $a["aa"] = 2;
}


function bizLogic(Immutable $i) {
    return $i->withX(2);
}


class Immutable
{
    private int $x;
    private Y $y;
    /** @var string[] */
    private array $list;

    /**
     * @param string[] $list
     */
    public function __construct(int $x, Y $y, array $list)
    {
        $this->x = $x;
        $this->y = $y;
        $this->list = $list;
    }

    public function getList(): array
    {
        return $this->list;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function withX(int $newX): self
    {
        return new self($newX,$this->y, $this->list);
    }

    public function getY(): Y
    {
        return $this->y;
    }
}
class Y {
    private int $gandamStyle;

    public function __construct(int $gandamStyle)
    {
        $this->gandamStyle = $gandamStyle;
    }

    /**
     * @param int $gandamStyle
     */
    public function setGandamStyle(int $gandamStyle): void
    {
        $this->gandamStyle = $gandamStyle;
    }
    public function getGandamStyle(): int
    {
        return $this->gandamStyle;
    }

}