<?php

namespace Leankoala\LeankoalaClient\Repository;

/**
 * Class UserRepository
 *
 * @package Leankoala\LeankoalaClient\Repository
 *
 * @author Nils Langner (nils.langner@leankoala.com)
 * @created 2020-04-29
 */
class SubscriptionRepository extends BaseRepository
{
    const ENDPOINT_SUBSCRIPTION_UPDATE = '/v1/user/subscriptions/{{user_id}}';

    const DATA_SUBSCRIPTION_COUNT = 'subscription_count';

    /**
     * @param $userId
     * @param $systemCount
     *
     * @return bool
     */
    public function updateSubscription($userId, $systemCount)
    {
        $connection = $this->getConnection();

        $payload = [
            'system_count' => $systemCount,
            'user_id' => $userId
        ];

        $result = $connection->sendPut(self::ENDPOINT_SUBSCRIPTION_UPDATE, $payload);

        return $result[self::DATA_SUBSCRIPTION_COUNT];
    }
}
