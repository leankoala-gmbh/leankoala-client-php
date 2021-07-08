<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2021-05-26
 */
class Auth2Repository extends Repository implements \Leankoala\ApiClient\Repository\MasterConnectionRepository {

  /**
   * @param application
   * @param {Object} args
   * @param {String} args.emailOrUserName 
   * @param {String} args.password 
   * @param {Boolean} args.withMemories If true all Memory entities will be attached in the answer. (default: false)
   */
  public function loginWithCredentials($application, $args)
  {
    $route = ['path' => '{application}/auth/login', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['application' => $application], $args);
    $requiredArguments = ['emailOrUserName', 'password'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Create a valid access token by the given refresh token.
   *
   * @param application
   * @param user
   * @param {Object} args
   * @param {Boolean} args.with_memories If true all Memory entities will be attached in the answer. (default: false)
   */
  public function createTokenByRefreshToken($application, $user, $args)
  {
    $route = ['path' => '{application}/auth/refresh/{user}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['application' => $application, 'user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Create a valid access token.
   *
   * @param application
   * @param user
   * @param {Object} args
   * @param {Boolean} args.with_memories If true all Memory entities will be attached in the answer. (default: false)
   */
  public function createToken($application, $user, $args)
  {
    $route = ['path' => '{application}/auth/token/{user}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['application' => $application, 'user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

}
