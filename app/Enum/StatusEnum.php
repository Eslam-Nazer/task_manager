<?php

namespace App\Enum;

use Illuminate\Support\Arr;

enum StatusEnum: string
{
    case PENDING = "pending";
    case IN_PROGRESS = "in-progress";
    case COMPLETED = "completed";

    public static function values()
    {
        return Arr::pluck(self::cases(), 'value');
    }
}
