<?php

namespace App\Service;

/**
 *  class Yodalizer
 */
class Yodalizer
{

    public static function yodalizeIt(string $str):string
    {
        return ucfirst(implode(' ',array_reverse(explode(' ', $str))));
    }
}

