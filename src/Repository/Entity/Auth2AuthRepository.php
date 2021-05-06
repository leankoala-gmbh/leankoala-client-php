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
class Auth2AuthRepository extends Repository {

  /**
   * @param application
   * @param {Object} args
   * @param {String} args.emailOrUserName 
   * @param {String} args.password 
   */
  public function loginWithCredentials($application, $args)
  {
    $route = ['path' => '/v1/{application}/auth/login', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['application' => $application], $args);
    $requiredArguments = ['emailOrUserName', 'password'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

}
