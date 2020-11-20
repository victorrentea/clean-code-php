<?php

/**
 * Created by PhpStorm.
 * User: VictorRentea
 * Date: 08-Nov-18
 * Time: 03:20 PM
 */

namespace victor\refactoring\gildedrose;

class GildedRoseClean implements IGildedRose
{
    private $items;

    /** @var Item[] */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function tick()
    {
        foreach ($this->items as $item) {
            $this->processItem($item);
        }
    }

    // IDEI cum poti sa implementezi logica diferita per tip de ceva
    // a) Sulfuras->process() + Sulfuras implements/extends Item {name(), quality(), sellin()}
    // b) Sulfuras implements Item { private Item $item; } - Decorator Pattern (TM)
    // c) switch


    private function processItem(Item $item): void
    {
        if ($item->name != 'Aged Brie' && $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                $item->decreaseQualityWithingRange();
            }
        } else {
            //49
            $item->increaseQualityWithinRange();

            if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                if ($item->sellIn < 11) {
                    $item->increaseQualityWithinRange();
                }
                if ($item->sellIn < 6) {
                    $item->increaseQualityWithinRange();
                }
            }
        }
        if ($item->name != 'Sulfuras, Hand of Ragnaros') {
            $item->sellIn = $item->sellIn - 1;
        }
        if ($item->sellIn < 0) {
            if ($item->name != 'Aged Brie') {
                if ($item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                    if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                        $item->decreaseQualityWithingRange();
                    }
                } else {
                    $item->zeroQuality();
                }
            } else {
                $item->increaseQualityWithinRange();
            }
        }
    }

}