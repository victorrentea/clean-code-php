<?php
namespace victor\refactoring\videostore;

class Movie
{
    const NEW_RELEASE = "NEW_RELEASE";
    const REGULAR = "REGULAR";
    const CHILDREN = "CHILDREN";
    private string $title;
    private string $priceCode;

    /**
     * Movie constructor.
     * @param string $title
     * @param string $priceCode
     */
    public function __construct(string $title, string $priceCode)
    {
        $this->title = $title;
        $this->priceCode = $priceCode;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getPriceCode() : string
    {
        return $this->priceCode;
    }

    /**
     * @param string $priceCode
     */
    public function setPriceCode(string $priceCode) : void
    {
        $this->priceCode = $priceCode;
    }

}