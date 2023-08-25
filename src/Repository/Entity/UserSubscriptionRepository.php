<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2023-08-25
 */
class UserSubscriptionRepository extends Repository  {

  /**
   * Update the subscription for a given user.
   *
   * @param user
   * @param {Object} args
   * @param {Number} args.system_count The number of systems the user is allowed to create.
   */
  public function update($user, array $args = [])
  {
    $route = ['path' => '/kapi/v1/user/subscriptions/{user}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['system_count'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

}
