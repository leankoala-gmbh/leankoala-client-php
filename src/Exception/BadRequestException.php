<?php

namespace Leankoala\ApiClient\Exception;

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

    public function __construct($message, $url, $method, $data)
    {
        parent::__construct($message);

        $this->url = $url;
        $this->method = $method;
        $this->data = $data;
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


}
