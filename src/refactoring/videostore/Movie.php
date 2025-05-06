<?php
namespace victor\refactoring\videostore;

readonly class Movie
{
    const NEW_RELEASE = "NEW_RELEASE";
    const REGULAR = "REGULAR";
    const CHILDREN = "CHILDREN";


    public function __construct(private string $title, private string $priceCode)
    {
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getPriceCode() : string
    {
        return $this->priceCode;
    }
}
