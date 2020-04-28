<?php

namespace Leankoala\LeankoalaClient\Client;

use GuzzleHttp\Client;

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

    private $accessToken;

    public function __construct(Client $httpClient, $apiServer, $username, $password)
    {
        $this->httpClient = $httpClient;
        $this->apiServer = $apiServer;

        $this->authenticate($username, $password);
    }

    private function authenticate($username, $password)
    {
        $result = $this->sendPost(self::ENDPOINT_AUTH_WITH_CREDENTIALS, ['username' => $username, 'password' => $password], false);
        $this->accessToken = $result['token'];
    }

    public function sendPost($endpoint, $payload, $withAccessToken = true)
    {
        if ($withAccessToken) {
            $payload[self::PAYLOAD_ACCESS_TOKEN] = $this->accessToken;
        }

        $endpoint = $this->getProcessEndpoint($endpoint, $payload);

        $response = $this->httpClient->post($endpoint, ['json' => $payload, 'http_errors' => false]);

        $responseArray = json_decode((string)$response->getBody(), true);

        if (!array_key_exists(self::RESPONSE_STATUS, $responseArray)) {
            throw new \RuntimeException('Not a valid Leankoala API response returned.');
        }

        if ($responseArray[self::RESPONSE_STATUS] === 'error') {
            throw new ApiError($responseArray['message']);
        }

        return $responseArray[self::RESPONSE_DATA];
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
