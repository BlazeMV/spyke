<?php

namespace Blaze\Spyke\Api\Requests;

use Blaze\Spyke\Api\Response;
use Blaze\Spyke\OmdbApi as Api;
use Blaze\Spyke\Exceptions\RequestException;
use Blaze\Spyke\Services\ConfigService;
use Blaze\Spyke\Services\HttpService;
use GuzzleHttp\Client;

abstract class BaseRequest
{
    /**
     * @var string $method
    */
    protected $method;
    
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
    
    public static function make()
    {
        $me = new static;
        $me->method = camel_case(class_basename(static::class));
        $me->http_service = new HttpService(new Client());
        return $me;
    }
    
    /**
     * get the class name of the response object to return
     * @return string
     */
    abstract protected function responseObject() : string ;
    
    /**
     * get the class name of the response object to return
     * @return bool
     */
    protected function multipleResponseObjects() : bool
    {
        return false;
    }
    
    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
    
    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
    
    /**
     * @param $key
     * @return mixed
     */
    public function getParam($key)
    {
        return $this->hasParam($key) ? $this->params[$key] : null;
    }
    
    /**
     * @param $key
     * @return mixed
     */
    public function hasParam($key)
    {
        return array_has($this->params, $key);
    }
    
    /**
     * @param array $params
     * @return BaseRequest
     */
    public function setParams(array $params): BaseRequest
    {
        $this->params = $params;
        return $this;
    }
    
    /**
     * @param $key
     * @param $value
     * @return BaseRequest
     */
    public function addParam($key, $value): BaseRequest
    {
        $this->params[$key] = $value;
        return $this;
    }
    
    /**
     * @return HttpService
     */
    public function getHttpService(): HttpService
    {
        return $this->http_service;
    }
    
    /**
     * @param HttpService $http_service
     * @return BaseRequest
     */
    public function setHttpService(HttpService $http_service): BaseRequest
    {
        $this->http_service = $http_service;
        return $this;
    }
    
    /**
     * @return Api
     */
    public function getApi(): Api
    {
        return $this->api;
    }
    
    /**
     * @param Api $api
     * @return BaseRequest
     */
    public function setApi(Api $api): BaseRequest
    {
        $this->api = $api;
        return $this;
    }
    
    /**
     * @return Response
     * @throws RequestException
     */
    public function send()
    {
        if ($this->api === null) {
            throw new RequestException("setApi() method must be called before calling send() method");
        }

        $response = $this->http_service->get($this->getUrl());
        
        if ($response->isOk()) {
            $response->setResponseObject($this->responseObject(), $this->multipleResponseObjects());
        }
        
        return $response;
    }
    
    /**
     * @return string
     */
    protected function getUrl()
    {
        $url = ConfigService::getOmdbApiUrl() . '/?apikey=' . $this->getApi()->getKey();

        foreach ($this->getParams() as $key => $value) {
            $url .= "&$key=" . urlencode($value);
        }

        return $url;
    }
}
