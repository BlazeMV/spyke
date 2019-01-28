<?php

namespace Blaze\Spyke\Api\Requests;

use Blaze\Spyke\Api\Response;
use Blaze\Spyke\OmdbApi as Api;
use Blaze\Spyke\Services\ConfigService;
use Blaze\Spyke\Services\HttpService;
use GuzzleHttp\Client;

class Request
{
    /**
     * @var array $params
    */
    protected $params = [];
    
    /**
     * HttpService that will be used to make the request
     *
     * @var HttpService $http_service
    */
    protected $http_service;
    
    /**
     * @var Api $api
    */
    protected $api;
    
    /**
     * @var string $response_object
    */
    protected $response_object;
    
    /**
     * Request constructor.
     *
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
        $this->http_service = new HttpService(new Client());
    }
    
    /**
     * @param $class
     * @return $this
     */
    public function setResponseObject($class)
    {
        $this->response_object = $class;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
    
    /**
     * @param array $params
     * @return Request
     */
    public function setParams(array $params): Request
    {
        $this->params = $params;
        return $this;
    }
    
    /**
     * @return Response
     */
    public function send()
    {
        $response = $this->http_service->get($this->getUrl());
        
        if ($response->isOk()) {
            $response->setResponseObject($this->response_object);
        }
        
        return $response;
    }
    
    /**
     * @return string
     */
    protected function getUrl()
    {
        $url = ConfigService::getOmdbApiUrl() . '/?apikey=' . $this->api->getKey();

        foreach ($this->getParams() as $key => $value) {
            $url .= "&$key=" . urlencode($value);
        }

        return $url;
    }
}
