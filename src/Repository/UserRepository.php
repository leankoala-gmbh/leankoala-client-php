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
class UserRepository extends BaseRepository
{
    const ENDPOINT_USER_CREATE = '/v1/user/users/{{provider}}';

    const ENDPOINT_USER_CONNECT_OAUTH = '/v1/user/oauth/{{user_id}}/connect';

    const DATA_USER_ID = 'user_id';

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
     * Create a new user.
     *
     * This api endpoint needs special authorization.
     *
     * @param string $provider
     * @param string $username
     * @param string $password
     * @param string $email
     * @param array $optionalFields
     *
     * @return int
     *
     * @throws ApiError
     */
    public function createUser($provider, $username, $password, $email, array $optionalFields = [])
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

        return $result[self::DATA_USER_ID];
    }

    public function connectOAuthAccount($userId, $oAuthProvider, $oAuthUserId)
    {
        $payload = ['user_id' => $userId, 'provider' => $oAuthProvider, 'provider_user_id' => $oAuthUserId];

        $this->getConnection()->sendPut(self::ENDPOINT_USER_CONNECT_OAUTH, $payload);

        return true;
    }
}
