<?php

namespace Leankoala\ApiClient\Exception;

use GuzzleHttp\Psr7\Response;

class BadRequestException extends \Exception
{
    private $url;
    private $method;
    private $data;
    private $response;
    private $identifier;

    public function __construct($message, $url, $method, $data, ?Response $response = null, $identifier = null)
    {
        parent::__construct($message);

        $this->url = $url;
        $this->method = $method;
        $this->data = $data;
        $this->response = $response;
        $this->identifier = $identifier;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * Return true if a response hat been attached.
     *
     * @return bool
     */
    public function hasResponse()
    {
        return !is_null($this->response);
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    /**
     * @return mixed|null
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @deprecated Use hasIdentifier() instead
     */
    #[\Deprecated(message: 'Use hasIdentifier() instead')]
    public function hadIdentifier(): bool
    {
        return $this->hasIdentifier();
    }

    public function hasIdentifier(): bool
    {
        return !is_null($this->identifier);
    }
}
