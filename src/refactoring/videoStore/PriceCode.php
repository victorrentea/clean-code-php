<?php

namespace victor\refactoring\videoStore;

enum PriceCode: string
{
    case NEW_RELEASE = 'NEW_RELEASE';
    case REGULAR = 'REGULAR';
    case CHILDREN = 'CHILDREN';
}
