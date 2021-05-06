<?php

namespace Leankoala\ApiClient\Connection;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
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
     * Mandatory routes that are needed before the repositories are initialized.
     *
     * @var array[]
     */
    private $routes = [
        "authenticateByPassword" => [
            "version" => 1,
            "path" => 'auth/tokens/access',
            "method" => 'POST'
        ],
        "refresh" => [
            "version" => 1,
            "path" => 'auth/tokens/refresh/{user_id}',
            "method" => 'POST'
        ]
    ];

    /**
     * Init routes and set default values
     *
     * @param string $apiServer
     * @param Client $httpClient
     */
    public function __construct($apiServer, Client $httpClient)
    {
        $this->apiServer = $apiServer;
        $this->httpClient = $httpClient;
    }

    /**
     * Connect to the KoalityEngine server and fetch the tokens and user information.
     *
     * @param string $username
     * @param string $password
     * @param array $args
     *
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws MissingArgumentException
     */
    public function connect($username, $password, $args)
    {
        if (array_key_exists('language', $args)) {
            $this->setLanguage($args['language']);
        }

        if (array_key_exists('withMemories', $args)) {
            $withMemories = $args['withMemories'];
        } else {
            $withMemories = false;
        }

        $this->authenticate($username, $password, $withMemories);
    }

    /**
     * Set the preferred language for the API results
     *
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->preferredLanguage = $language;
    }

    /**
     * Authenticate the user using username and password.
     *
     * This function will set the access and refresh tokens that are used afterwards for authentication.
     *
     * @param string $username
     * @param string $password
     * @param bool $withMemories
     *
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws MissingArgumentException
     */
    private function authenticate($username, $password, $withMemories)
    {
        $tokens = $this->send($this->routes['authenticateByPassword'], [
            'username' => $username,
            'password' => $password,
            'with_memories' => $withMemories
        ], true);

        $this->accessToken = $tokens->token;
        $this->user = $tokens->user;
    }

    /**
     * @param $route
     * @param $data
     * @param bool $withoutToken
     *
     * @return mixed
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws MissingArgumentException
     */
    public function send($route, $data, $withoutToken = false)
    {
        $method = strtoupper($route['method']);
        $url = $this->getUrl($route, $data);

        $headers = ['accept-language' => $this->preferredLanguage];

        if ($withoutToken !== true) {
            $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        try {
            $response = $this->httpClient->request($method, $url, [
                'headers' => $headers,
                RequestOptions::JSON => $data
            ]);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
        }

        $this->assertValidResponse($response, $url, $method, $data);

        $responseJson = (string)$response->getBody();
        $responseObject = json_decode($responseJson);

        return $responseObject->data;
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
        preg_match_all('/{(.*)}/', $path, $matches);

        $url = $this->apiServer . 'v' . $route['version'] . '/' . $path;

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

        if (is_null($responseData)) {
            throw new BadRequestException(
                "The servers response is not valid JSON. \n\n" . substr((string)$response->getBody(), 0, 200),
                $url, $method, $data);
        }

        if ($responseData->status !== 'success') {
            throw new BadRequestException($responseData->message, $url, $method, $data);
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
