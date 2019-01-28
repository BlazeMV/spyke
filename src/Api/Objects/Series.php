<?php

namespace Blaze\Spyke\Api\Objects;

use Blaze\Spyke\Api\ApiObject;

class Series extends ApiObject
{
    /**
     * @inheritdoc
     */
    protected function multipleObjectRelations() : array
    {
        return [
            'Ratings' => Rating::class,
            'Episodes' => Rating::class
        ];
    }
}