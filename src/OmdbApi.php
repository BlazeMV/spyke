<?php

namespace Blaze\Spyke;

use Blaze\Spyke\Api\Requests\BaseRequest;
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
     * @param BaseRequest $request
     * @return Api\Response
     * @throws Exceptions\RequestException
     */
    public function call(BaseRequest $request)
    {
        return $request->setApi($this)->send();
    }
}