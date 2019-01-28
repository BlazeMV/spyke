<?php

namespace Blaze\Spyke\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Blaze\Spyke\Api\Response;

/**
 * Used to make requests to APIs and return responses.
 *
 * Class HttpService
 * @package Blaze\Myst\Services
 */
class HttpService
{
    /**
     * @var Client $client
     */
    private $client;
    
    /**
     * Headers to be set on every request
     *
     * @var array $headers
     */
    private $headers = [
        'Accept' => 'application/json',
        'Connection' => 'keep-alive',
        'Accept-Language' => 'en-US,en;q=0.9'
    ];
    
    /**
     * HttpService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    /**
     * @param string $url
     * @return Response
     */
    public function get($url)
    {
        return $this->makeRequest('GET', $url);
    }
    
    /**
     * @param string $method
     * @param string $url
     * @return Response
     */
    private function makeRequest($method, $url)
    {
        $options = [];
        $options['headers'] = $this->headers;

        $response = null;
        $exception = null;
        $code = 0;
        try {
            $response = $this->client->request($method, $url, $options);
            $code = $response->getStatusCode();
        } catch (\Throwable $throwable) {
            $exception = $throwable;
            if ($throwable instanceof RequestException && $throwable->hasResponse()) {
                $response = $throwable->getResponse();
                $code = $response->getStatusCode();
            }
        }
        
        return new Response($code, $response, $exception);
    }
    
    /**
     * add headers to request
     * @param array $headers
     * @return array
     */
    public function addHeaders(array $headers)
    {
        foreach ($headers as $key => $header) {
            $this->headers[$key] = $header;
        }
        return $this->headers;
    }
}
