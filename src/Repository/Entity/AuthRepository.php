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
class AuthRepository extends Repository  {

  /**
   * This function creates an access token with all the permissions for the given user. The returned
   * token has to be in the payload for every later request.
   *
   * @param {Object} args
   * @param {String} args.username The username you want to log in with.
   * @param {String} args.password The users password.
   * @param {Boolean} args.expire If true the token will not expire (only available for admin users). (default: true)
   * @param {Boolean} args.with_memories If true all memory entities will be attached in the answer. (default: false)
   *
   * @return {createTokenByCredentialsResult}
   */
  public function createTokenByCredentials(array $args = [])
  {
    $route = ['path' => '/kapi/v1/auth/tokens/access', 'method' => 'POST', 'version' =>  1];
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
  public function createTokenByRefreshToken($user, array $args = [])
  {
    $route = ['path' => '/kapi/v1/auth/tokens/refresh/{user}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

}
