<?php

namespace Leankoala\LeankoalaClient\Repository;

use Leankoala\LeankoalaClient\Client\ApiError;
use Leankoala\LeankoalaClient\Client\NotFoundApiError;

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
    const ENDPOINT_USER_EXISTS = '/v1/user/users/exists';
    const ENDPOINT_USER_FIND = '/v1/user/users/find';

    const ENDPOINT_USER_CONNECT_OAUTH = '/v1/user/oauth/{{user_id}}/connect';

    const DATA_USER_ID = 'user_id';

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
        if (!$provider) {
            throw new \RuntimeException('The provider must not be emtpty or null.');
        }

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

    public function findUser($query)
    {
        $payload = [
            'query' => $query
        ];

        try {
            $result = $this->getConnection()->sendGet(self::ENDPOINT_USER_FIND, $payload);
        } catch (NotFoundApiError $e) {
            return false;
        }

        return $result['user_id'];
    }

    public function userExists($query)
    {
        $payload = [
            'query' => $query
        ];

        $result = $this->getConnection()->sendGet(self::ENDPOINT_USER_EXISTS, $payload);

        return $result['exists'];
    }
}
