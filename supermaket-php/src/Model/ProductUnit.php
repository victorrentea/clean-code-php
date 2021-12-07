<?php

declare(strict_types=1);

namespace Supermarket\Model;

use MyCLabs\Enum\Enum;

enum ProductUnit
{
    case EACH;
    case KILO;
}