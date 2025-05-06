<?php
namespace victor\refactoring\videostore;

enum PriceCodeEnum: string
{
    case NEW_RELEASE = 'NEW_RELEASE';
    case REGULAR = 'REGULAR';
    case CHILDREN = 'CHILDREN';
}