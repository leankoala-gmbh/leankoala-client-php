<?php

namespace Leankoala\LeankoalaClient\Client;

use GuzzleHttp\Client;

/**
 * Class Connection
 *
 * @package Leankoala\LeankoalaClient\Client
 *
 * @author Nils Langner (nils.langner@leankoala.com)
 * @created 2020-04-29
 */
class Connection
{
    const ENDPOINT_AUTH_WITH_CREDENTIALS = '/v1/auth/tokens/access';

    const PAYLOAD_ACCESS_TOKEN = 'access_token';

    const RESPONSE_STATUS = 'status';
    const RESPONSE_DATA = 'data';

    const ENDPOINT_PARAMETER_PATTERN = '/{{(.*?)}}/';

    private $apiServer;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * The json web token
     *
     * @var string
     */
    private $accessToken;

    /**
     * Connection constructor.
     *
     * @param Client $httpClient
     * @param $apiServer
     * @param $usernameOrJwt
     * @param null $password
     *
     * @throws ApiError
     */
    public function __construct(Client $httpClient, $apiServer, $usernameOrJwt, $password = null)
    {
        $this->httpClient = $httpClient;
        $this->apiServer = $apiServer;

        if (!$password) {
            $this->accessToken = $usernameOrJwt;
        } else {
            $this->authenticate($usernameOrJwt, $password);
        }
    }

    /**
     * @param $username
     * @param $password
     *
     * @throws ApiError
     */
    private function authenticate($username, $password)
    {
        $result = $this->sendPost(self::ENDPOINT_AUTH_WITH_CREDENTIALS, ['username' => $username, 'password' => $password], false);
        $this->accessToken = $result['token'];
    }

    /**
     * Send a POST request to the Leankoala API.
     *
     * @param string $endpoint
     * @param array $payload
     * @param bool $withAccessToken
     *
     * @return array
     *
     * @throws ApiError
     */
    public function sendPost($endpoint, $payload, $withAccessToken = true)
    {
        return $this->sendRequest('POST', $endpoint, $payload, $withAccessToken);
    }

    public function sendPut($endpoint, $payload, $withAccessToken = true)
    {
        return $this->sendRequest('PUT', $endpoint, $payload, $withAccessToken);
    }

    /**
     * Send the actual request via the given method
     *
     * @param string $method
     * @param string $endpoint
     * @param array $payload
     * @param bool $withAccessToken
     *
     * @return mixed
     *
     * @throws ApiError
     */
    private function sendRequest($method, $endpoint, $payload, $withAccessToken)
    {
        if ($withAccessToken) {
            $payload[self::PAYLOAD_ACCESS_TOKEN] = $this->accessToken;
        }

        $endpoint = $this->getProcessEndpoint($endpoint, $payload);

        switch ($method) {
            case 'POST':
                $response = $this->httpClient->post($endpoint, ['json' => $payload, 'http_errors' => false]);
                break;
            case 'GET':
                $response = $this->httpClient->get($endpoint, ['json' => $payload, 'http_errors' => false]);
                break;
            case 'PUT':
                $response = $this->httpClient->put($endpoint, ['json' => $payload, 'http_errors' => false]);
                break;
            default:
                throw new \RuntimeException('Unknown method ' . $method . '.');
        }

        $body = (string)$response->getBody();

        if (is_null($body) || $body == '') {
            $e = new ApiError('The Leankoala API responded with an empty body.');
            $e->setUrl($endpoint);
            $e->setPayload($payload);
            throw $e;
        }

        $responseArray = json_decode((string)$response->getBody(), true);

        if (!array_key_exists(self::RESPONSE_STATUS, $responseArray)) {
            throw new \RuntimeException('Not a valid Leankoala API response returned.');
        }

        if ($responseArray[self::RESPONSE_STATUS] === 'error') {
            $e = new ApiError($responseArray['message']);
            $e->setPayload($payload);
            $e->setUrl($endpoint);
            throw $e;
        }

        if (array_key_exists(self::RESPONSE_DATA, $responseArray)) {
            return $responseArray[self::RESPONSE_DATA];
        } else {
            return [];
        }
    }

    private function getProcessEndpoint($endpoint, $payload)
    {
        preg_match_all(self::ENDPOINT_PARAMETER_PATTERN, $endpoint, $matches);

        foreach ($matches[1] as $position => $varName) {
            if (array_key_exists($varName, $payload)) {
                $endpoint = str_replace($matches[0][$position], $payload[$varName], $endpoint);
            } else {
                throw new \RuntimeException('The parameter "' . $varName . " is not part of the given payload and can therefore not be processed.");
            }

        }

        return $this->apiServer . $endpoint;
    }
}
