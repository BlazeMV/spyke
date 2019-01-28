<?php

namespace Blaze\Spyke;

class Helpers
{
    public static function ArrayValueExistsRecursive(array $array, $value)
    {
        if (in_array($value, $array)) return true;
        foreach ($array as $data) {
            if (is_array($data)) {
                if (self::ArrayValueExistsRecursive($data, $value) === true) {
                    return true;
                }
            }
        }
        return false;
    }
}