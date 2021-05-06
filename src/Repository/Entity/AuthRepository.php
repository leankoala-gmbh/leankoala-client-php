<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2021-05-06
 */
class AuthRepository extends Repository  {

  /**
   * @param {Object} args
   * @param {String} args.username 
   * @param {String} args.password 
   * @param {Boolean} args.expire  (default: true)
   * @param {Boolean} args.with_memories If true all Memory entities will be attached in the answer. (default: false)
   *
   * @return {createTokenByCredentialsResult}
   */
  public function createTokenByCredentials($args)
  {
    $route = ['path' => 'auth/tokens/access', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['username', 'password'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * @param user
   * @param {Object} args
   * @param {Boolean} args.with_memories If true all Memory entities will be attached in the answer. (default: false)
   */
  public function createTokenByRefreshToken($user, $args)
  {
    $route = ['path' => 'auth/tokens/refresh/{user}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

}
