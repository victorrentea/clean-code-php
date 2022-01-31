<?php
namespace victor\refactoring\videostore;

class Movie
{
    const NEW_RELEASE = "NEW_RELEASE";
    const REGULAR = "REGULAR";
    const CHILDREN = "CHILDRENS"; // daca cumva "CHILDRENS" apare in JS/HTML/DB -> NU ATINGI! parte din APIul tau

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

}