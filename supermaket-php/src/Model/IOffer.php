<?php

namespace Supermarket\Model;

interface IOffer
{
    public function getArgument(): float;

    public function getOfferType(): SpecialOfferType;
}