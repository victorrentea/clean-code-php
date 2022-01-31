<?php
namespace victor\refactoring\videostore;

// enum MovieType {
//
// }
class Movie
{
    const NEW_RELEASE = "NEW_RELEASE";
    const REGULAR = "REGULAR";
    const CHILDREN = "CHILDREN";

    private string $title;

    private string $priceCode;

    public function __construct(string $title, string $priceCode)
    {
        $this->title = $title;
        $this->priceCode = $priceCode;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPriceCode(): string
    {
        return $this->priceCode;
    }

    public function isNewRelease(): bool
    {
        return $this->getPriceCode() == Movie::NEW_RELEASE;
    }

}