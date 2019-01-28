<?php

namespace Blaze\Spyke\Api;

use Psr\Http\Message\ResponseInterface;

/**
 * Represents a Response from an Api request
 * Class Response
 * @package Blaze\Myst\Api\Response
 */
class Response
{
    /**
     * @var int $statusCode
     */
    protected $statusCode;
    
    /**
     * @var ResponseInterface $response
     */
    protected $response;
    
    /**
     * @var \Throwable $exception
     */
    protected $exception;
    
    /**
     * @var mixed
     */
    protected $object;
    
    private static $scalar_types = [
        'int',
        'integer',
        'bool',
        'boolean',
        'float',
        'double',
        'real',
        'string',
        'array',
        'object',
        'unset'
    ];
    
    /**
     * Response constructor.
     *
     * @param int $statusCode
     * @param ResponseInterface|null $response
     * @param \Throwable|null $exception
     */
    public function __construct(
        int $statusCode,
        ResponseInterface $response = null,
        \Throwable $exception = null
    ) {
        $this->statusCode = $statusCode;
        $this->response = $response;
        $this->exception = $exception;
    }
    
    /**
     * whether or not this response is an ok response (http code 200 - 299)
     * @return bool
     */
    public function isOk() : bool
    {
        if ($this->getStatusCode() >=200
            && $this->getStatusCode() < 300
            && $this->getResponse()
            && $this->getResponseBody()['Response']
            && $this->getResponseBody()['Response'] === 'True') {
            return true;
        }
        
        return false;
    }
    
    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
    
    /**
     * @return ResponseInterface|null
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * @return \Throwable|null
     */
    public function getException()
    {
        return $this->exception;
    }
    
    /**
     * @return array|null
     */
    public function getResponseBody()
    {
        if ($this->getResponse() === null) {
            return null;
        }
        $this->getResponse()->getBody()->rewind();
        return json_decode($this->getResponse()->getBody()->getContents(), true);
    }
    
    /**
     * @return null|string
     */
    public function getErrorMessage()
    {
        if ($this->getStatusCode() === 0) {
            return 'Unknown Response';
        }
        
        if (isset($this->getResponseBody()['Error'])) {
            return $this->getResponseBody()['Error'];
        }
        
        if ($this->getResponse() !== null) {
            return $this->getResponse()->getReasonPhrase();
        }
        
        if ($this->getException()) {
            return $this->getException()->getMessage();
        }
        
        return null;
    }
    
    /**
     * @param $class
     * @param bool $multiple
     * @return $this
     */
    public function setResponseObject($class, bool $multiple = false)
    {
        if (in_array($class, static::$scalar_types)) {
            $this->object = $this->getResponseBody();
            settype($this->object, $class);
        } else {
            if ($multiple) {
                foreach ($this->getResponseBody() as $item) {
                    $this->object[] = new $class($item);
                }
            } else {
                $this->object = new $class($this->getResponseBody());
            }
        }
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getResponseObject()
    {
        return $this->object;
    }
}
