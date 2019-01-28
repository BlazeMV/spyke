<?php

namespace Blaze\Spyke\Api\Objects;

use Blaze\Spyke\Api\ApiObject;

/**
 * @method int getSource()
 */
class Rating extends ApiObject
{
    public function getValue()
    {
        $value = $this->get('Value');
        if (strpos($value, '%') !== false) {
            return (floatval($value) / 10) . "/10";
        }
        if (strpos($value, '/') !== false) {
            $parts = explode('/', $value);
            if ($parts[1] == 10) {
                return $value;
            } else {
                return (($parts[0] / $parts[1]) * 10) . "/10";
            }
        }
        return $value;
    }
}