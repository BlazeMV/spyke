<?php

namespace Blaze\Spyke\Api\Objects;

use Blaze\Spyke\Api\ApiObject;

class Movie extends ApiObject
{
    /**
     * @inheritdoc
     */
    protected function multipleObjectRelations() : array
    {
        return [
            'Ratings' => Rating::class
        ];
    }
}