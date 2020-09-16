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
}