<?php

namespace victor\refactoring\videoStore;

readonly class Movie
{
    public function __construct(
        private string    $title,
        private PriceCode $priceCode
    )
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPriceCode(): PriceCode
    {
        return $this->priceCode;
    }
}
