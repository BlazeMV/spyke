<?php

namespace Blaze\Spyke\Api\Objects;

use Blaze\Spyke\Api\ApiObject;
use Blaze\Spyke\Exceptions\SpykeException;

class Search extends ApiObject
{
    /**
     * @inheritdoc
     */
    protected function multipleObjectRelations() : array
    {
        return [
            'Ratings' => Rating::class,
            'Search' => function (array $data) {
                switch ($data['Type']) {
                    case 'movie':
                        return Movie::class;
                        break;
                    case 'series':
                        return Series::class;
                        break;
                    case 'episode':
                        return Episode::class;
                        break;
                    case 'game':
                        return Game::class;
                        break;
                }
                throw new SpykeException("Unknown response object type");
            }
        ];
    }
    
    protected function proposedPropertyAliases(): array
    {
        return [
            'Search' => 'Result'
        ];
    }
}