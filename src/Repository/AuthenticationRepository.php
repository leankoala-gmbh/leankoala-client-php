<?php

namespace Leankoala\LeankoalaClient\Repository;

use Leankoala\LeankoalaClient\Client\ApiError;

/**
 * Class AuthenticationRepository
 *
 * @package Leankoala\LeankoalaClient\Repository
 *
 * @author Nils Langner (nils.langner@leankoala.com)
 * @created 2020-04-29
 */
class AuthenticationRepository extends BaseRepository
{
    const ENDPOINT_GET_USER_TOKEN = '/v1/auth/tokens/{{user_id}}';

    const TOKEN_ACCESS = 'token';
    const TOKEN_REFRESH = 'refreshToken';

    /**
     * @param int $userId
     *
     * @return string[]
     *
     * @throws ApiError
     */
    public function getUserTokens($userId)
    {
        $payload = [
            'user_id' => $userId
        ];

        return $this->getConnection()->sendPost(self::ENDPOINT_GET_USER_TOKEN, $payload);
    }
}
