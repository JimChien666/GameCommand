<?php

namespace App\Utils;

use Carbon\Carbon;

class Utils
{

    public static function textWithTime(string $text)
    {
        return "[" . Carbon::now()->addHours(8) . "]" . $text;
    }
}
