<?php
namespace victor\refactoring\videostore;

class Movie
{
    public const TYPE_NEW_RELEASE = "NEW_RELEASE";
    public const TYPE_REGULAR = "REGULAR";
    public const TYPE_CHILDREN = "CHILDRENS";

    private string $title;

    private string $type;

    public function __construct(string $title, string $type)
    {
        $this->title = $title;
        $this->type = $type;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isNewRelease(): bool
    {
        return $this->type == Movie::TYPE_NEW_RELEASE;
    }

//    public abstract function computePrice(int $daysRented): float;
}
//class RegularMovie extends Movie {
//
//    public function computePrice(int $daysRented): float
//    {
//        $thisAmount = 2;
//        if ($this->daysRented > 2) {
//            $thisAmount += ($this->daysRented - 2) * 1.5;
//        }
//    }
//}