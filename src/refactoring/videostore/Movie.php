<?php
namespace victor\refactoring\videostore;

readonly class Movie
{
    public function __construct(
        private string $title,
        private PriceCodeEnum $priceCode
    ) {
    }


    public function getTitle(): string
    {
        return $this->title;
    }


    public function getPriceCode(): PriceCodeEnum
    {
        return $this->priceCode;
    }
}