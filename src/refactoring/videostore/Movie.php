<?php
namespace victor\refactoring\videostore;

class Movie
{
    const NEW_RELEASE = "NEW_RELEASE";
    const REGULAR = "REGULAR";
    const CHILDRENS = "CHILDRENS";

    private $title;

    private $priceCode;

    /**
     * Movie constructor.
     * @param string $title
     * @param string $priceCode
     */
    public function __construct($title, $priceCode)
    {
        $this->title = $title;
        $this->priceCode = $priceCode;
    }

    public function getTitle(): mixed
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getPriceCode(): mixed
    {
        return $this->priceCode;
    }

    /**
     * @param mixed $priceCode
     */
    public function setPriceCode($priceCode)
    {
        $this->priceCode = $priceCode;
    }

}