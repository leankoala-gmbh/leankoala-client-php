<?php

namespace Leankoala\ApiClient\Connection;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Leankoala\ApiClient\Exception\BadRequestException;
use Leankoala\ApiClient\Exception\MissingArgumentException;
use Leankoala\ApiClient\Exception\NotConnectedException;

/**
 * Class Connection
 *
 * @package Leankoala\ApiClient\Connection
 *
 * @author Nils Langner <nils.langner@leankoala.com>
 * created 2021-05-05
 */
class Connection
{
    /**
     * The JWT access token.
     *
     * @var string
     */
    private $accessToken = '';

    /**
     * The users information.
     *
     * @var array
     */
    private $user = [];

    /**
     * The API servers base URL.
     *
     * @var string
     */
    private $apiServer;

    /**
     * The preferred language of the response.
     *
     * @var string
     */
    private $preferredLanguage = 'en';

    /**
     * The HTTP client.
     *
     * @var Client
     */
    private $httpClient;

    /**
     * @var array
     */
    private $defaultParameters = [];

    /**
     * Init routes and set default values
     *
     * @param Client $httpClient
     * @param array $defaultParameters
     */
    public function __construct(Client $httpClient, $defaultParameters = [])
    {
        $this->httpClient = $httpClient;
        $this->defaultParameters = $defaultParameters;
    }

    public function setApiServer($apiServer)
    {
        $this->apiServer = $apiServer;
    }

    /**
     * Add a new default parameter that will be added to every request that is send.
     *
     * @param string $parameter
     * @param string $value
     */
    public function addDefaultParameter($parameter, $value)
    {
        $this->defaultParameters[$parameter] = $value;
    }

    /**
     * Register the access token for JWT handling.
     *
     * @param $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->addDefaultParameter('access_token', $accessToken);
    }


    /**
     * Get the access token for JWT handling.
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param $route
     * @param $data
     * @param bool $withoutToken
     *
     * @return mixed
     *
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws MissingArgumentException
     */
    public function send($route, $data, $withoutToken = false)
    {
        $fullData = array_merge($this->defaultParameters, $data);

        $method = strtoupper($route['method']);
        $url = $this->getUrl($route, $fullData);

        $headers = ['accept-language' => $this->preferredLanguage];

        if ($withoutToken !== true && $this->accessToken) {
            $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        try {
            $response = $this->httpClient->request($method, $url, [
                RequestOptions::HEADERS => $headers,
                RequestOptions::JSON => $fullData
            ]);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
        } catch (ServerException $exception) {
            $response = $exception->getResponse();
        }

        $this->assertValidResponse($response, $url, $method, $fullData);

        $responseJson = (string)$response->getBody();
        $responseObject = json_decode($responseJson, true);

        if(!array_key_exists('data', $responseObject)) {
            return true;
        }

        return $responseObject['data'];
    }

    /**
     * Return a valid URL.
     *
     * All path parameters will be filled by values from the data array and the
     * base URL depending on the environment will be added.
     *
     * @throws MissingArgumentException
     */
    private function getUrl($route, $data)
    {
        $path = $route['path'];

        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        preg_match_all('/{(.*?)}/', $path, $matches);

        if (array_key_exists('server', $route)) {
            $apiServer = $route['server'];
        } else {
            $apiServer = $this->apiServer;
        }

        $url = $apiServer . 'v' . $route['version'] . '/' . $path;

        foreach ($matches[1] as $match) {
            if (!array_key_exists($match, $data)) {
                throw new MissingArgumentException('The argument "' . $match . '" is mandatory but not set.');
            }

            $url = str_replace('{' . $match . '}', $data[$match], $url);
        }

        return $url;
    }

    /**
     * Throw an exception if the response is not a valid or successful KoalityEngine response.
     *
     * @param Response response
     * @param string url
     * @param string method
     * @param array data
     *
     * @throws BadRequestException
     */
    private function assertValidResponse($response, $url, $method, $data)
    {
        $responseData = json_decode((string)$response->getBody());

        if($response->getStatusCode() === 500) {
            throw new BadRequestException(
                "The servers responded with an internal server error (HTTP 500)). \n\n" . substr((string)$response->getBody(), 0, 200),
                $url, $method, $data, $response);
        }

        if (is_null($responseData)) {
            throw new BadRequestException(
                "The servers response is not valid JSON. \n\n" . substr((string)$response->getBody(), 0, 200),
                $url, $method, $data, $response);
        }

        if ($responseData->status !== 'success') {
            if (property_exists($responseData, 'identifier')) {
                $identifier = $responseData->identifier;
            } else {
                $identifier = null;
            }
            throw new BadRequestException($responseData->message . ' (url: ' . $url . ')', $url, $method, $data, $response, $identifier);
        }
    }

    /**
     * Get the currently logged in user.
     *
     * @return array
     *
     * @throws NotConnectedException
     */
    public function getUser()
    {
        if (!$this->accessToken) {
            throw new NotConnectedException('The connect() request was not done. No user data set.');
        }

        return $this->user;
    }
}
