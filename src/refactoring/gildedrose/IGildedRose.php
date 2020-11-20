<?php

namespace victor\refactoring\gildedrose;

interface IGildedRose
{
    /**
     * @return Item[]
     */
    public function getItems(): array;

    public function tick();
}