<?php

namespace Leankoala\ApiClient\Exception;

use GuzzleHttp\Psr7\Response;

/**
 * Class BadRequestException
 *
 * @package Leankoala\ApiClient\Exception
 *
 * @author Nils Langner <nils.langner@leankoala.com>
 * created 2021-05-05
 */
class BadRequestException extends \Exception
{
    private $url;
    private $method;
    private $data;
    private $response;

    public function __construct($message, $url, $method, $data, Response $response = null)
    {
        parent::__construct($message);

        $this->url = $url;
        $this->method = $method;
        $this->data = $data;
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
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

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
