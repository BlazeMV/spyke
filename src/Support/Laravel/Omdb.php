<?php

namespace Blaze\Myst\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Blaze\Spyke\Api\Response search(string $query, string $type=null, int $year=null, int $page=1)
 * @method static \Blaze\Spyke\Api\Response fetchById(string $id, string $type=null, int $year=null, $plot='short')
 * @method static \Blaze\Spyke\Api\Response fetchByTitle(string $title, string $type=null, int $year=null, $plot='short')
 */
class Omdb extends Facade
{
    /**
     * Get the registered name of the component.
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Blaze\Spyke\OmdbApi::class;
    }
}
