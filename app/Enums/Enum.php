<?php

namespace App\Enums;

use ReflectionClass;
use ReflectionException;

class Enum
{
    /**
     * @return array
     */
    public static function toArray() : array
    {
        try {
            return (new ReflectionClass(static::class))->getConstants();
        } catch (ReflectionException $e){
            return [];
        }
    }

    /**
     * @param string $glue
     * @return string
     */
    public static function toString(string $glue = ',') : string
    {
        return implode($glue, self::toArray());
    }
}
