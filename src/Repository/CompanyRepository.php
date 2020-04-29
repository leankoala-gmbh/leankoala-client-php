<?php

namespace Leankoala\LeankoalaClient\Repository;

use Leankoala\LeankoalaClient\Client\ApiError;

/**
 * Class UserRepository
 *
 * @package Leankoala\LeankoalaClient\Repository
 *
 * @author Nils Langner (nils.langner@leankoala.com)
 * @created 2020-04-29
 */
class CompanyRepository extends BaseRepository
{
    const ENDPOINT_USER_CREATE = '/v1/user/users/{{provider}}';

    const OAUTH_PROVIDER_AUTH0 = 'auth0';

    /**
     * @param $oauthProvider
     * @param $oauthId
     *
     * @return int
     */
    public function addOauthToUser($oauthProvider, $oauthId)
    {
        return 42;
    }

    /**
     * @param $provider
     * @param $username
     * @param $password
     * @param $email
     * @param array $optionalFields
     * @return int
     * @throws ApiError
     */
    public function createUser($provider, $username, $password, $email ,array $optionalFields = [])
    {
        $connection = $this->getConnection();

        $payload = array_merge(
            [
                'provider' => $provider,
                'username' => $username,
                'password' => $password,
                'email' => $email
            ],
            $optionalFields
        );

        $result = $connection->sendPost(self::ENDPOINT_USER_CREATE, $payload);

        var_dump($result);

        return 42;
    }
}
