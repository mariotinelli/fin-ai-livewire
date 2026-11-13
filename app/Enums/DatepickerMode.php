<?php

declare(strict_types = 1);

namespace App\Enums;

enum DatepickerMode: string
{
    case Single   = 'single';
    case Range    = 'range';
    case Multiple = 'multiple';
}
