<?php

namespace Blaze\Spyke;

use Blaze\Spyke\Api\Objects\Episode;
use Blaze\Spyke\Api\Objects\Game;
use Blaze\Spyke\Api\Objects\Movie;
use Blaze\Spyke\Api\Objects\Search;
use Blaze\Spyke\Api\Objects\Series;
use Blaze\Spyke\Api\Requests\Request;
use Blaze\Spyke\Exceptions\SpykeException;
use Blaze\Spyke\Services\ConfigService;

class OmdbApi
{
    /**
     * @var string $api_key
    */
    protected $api_key;

    /**
     * Api constructor.
     * @param array $config
     * @throws \Blaze\Spyke\Exceptions\ConfigException
     */
    public function __construct(array $config)
    {
        ConfigService::validateConfig($config);

        $this->api_key = $config['api_key'];
    }

    /**
     * @return mixed|string
     */
    public function getKey()
    {
        return $this->api_key;
    }
    
    /**
     * @param string $query
     * @param string|null $type
     * @param int|null $year
     * @param int $page
     * @return Api\Response
     */
    public function search(string $query, string $type=null, int $year=null, int $page=1)
    {
        
        $params = [];
        $params['s'] = $query;
        if ($type !== null) $params['type'] = $type;
        if ($year !== null) $params['y'] = $year;
        if ($page != 1) $params['page'] = $page;
        
        $request = new Request($this);
        $request->setParams($params);
        $request->setResponseObject(Search::class);
        $response = $request->send();
        
        return $response;
    }
    
    /**
     * @param string $id
     * @param string|null $type
     * @param int|null $year
     * @param string $plot
     * @return Api\Response
     */
    public function fetchById(string $id, string $type=null, int $year=null, $plot='short')
    {
        $params = [];
        $params['i'] = $id;
        if ($type !== null) $params['type'] = $type;
        if ($year !== null) $params['y'] = $year;
        if ($plot !== 'short') $params['plot'] = $plot;
    
        $request = new Request($this);
        $request->setParams($params);
        $request->setResponseObject(
            function (array $data) {
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
        );
        $response = $request->send();
        
        return $response;
    }
    
    /**
     * @param string $title
     * @param string|null $type
     * @param int|null $year
     * @param string $plot
     * @return Api\Response
     */
    public function fetchByTitle(string $title, string $type=null, int $year=null, $plot='short')
    {
        $params = [];
        $params['t'] = $title;
        if ($type !== null) $params['type'] = $type;
        if ($year !== null) $params['y'] = $year;
        if ($plot !== 'short') $params['plot'] = $plot;
    
        $request = new Request($this);
        $request->setParams($params);
        $request->setResponseObject(
            function (array $data) {
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
        );
        $response = $request->send();
        
        return $response;
    }
}