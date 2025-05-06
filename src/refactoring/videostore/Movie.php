<?php declare(strict_types = 1);

namespace victor\refactoring\videostore;
class Movie
{
    public const NEW_RELEASE = "NEW_RELEASE";
    public const REGULAR = "REGULAR";
    public const CHILDRENS = "CHILDRENS";
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return void
     */
    public function setTitle(mixed $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getPriceCode(): string
    {
        return $this->priceCode;
    }

    /**
     * @param mixed $priceCode
     * @return void
     */
    public function setPriceCode(mixed $priceCode): void
    {
        $this->priceCode = $priceCode;
    }
}
