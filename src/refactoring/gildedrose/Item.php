<?php
/**
 * Created by PhpStorm.
 * User: VictorRentea
 * Date: 16-Apr-19
 * Time: 03:35 PM
 */

namespace victor\refactoring\gildedrose;


class Item
{
    const MAX_QUALITY = 50;
    const MIN_QUALITY = 0;
    public $name;
    public $quality; // TODO plecatDe5Ani 2013: fa-o private
    public $sellIn;

    public function __construct(string $name, int $quality, int $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }
//public function isLegendary():bool {
//
//}

    public function quality(): int
    {
        return $this->quality;
    }
    public function increaseQualityWithinRange(): void
    {
        if ($this->quality < self::MAX_QUALITY) {
            $this->quality++;
        }
    }

    public function decreaseQualityWithingRange(): void
    {
        if ($this->quality > self::MIN_QUALITY) {
            $this->quality--;
        }
    }

    public function zeroQuality(): void
    {
        $this->quality = 0;
    }

}