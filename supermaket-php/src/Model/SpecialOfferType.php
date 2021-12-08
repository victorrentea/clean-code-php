<?php

declare(strict_types=1);

namespace Supermarket\Model;

use MyCLabs\Enum\Enum;

enum SpecialOfferType
{
    case THREE_FOR_TWO;

    case TEN_PERCENT_DISCOUNT;

    case TWO_FOR_AMOUNT;

    case FIVE_FOR_AMOUNT;

}


