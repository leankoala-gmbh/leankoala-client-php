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
class UserRepository extends Repository implements \Leankoala\ApiClient\Repository\MasterConnectionRepository {

  /**
   * @param application
   * @param {Object} args
   * @param {String} args.userName 
   * @param {String} args.email 
   * @param {String} args.password 
   * @param {Number} args.company  (optional)
   */
  public function createUser($application, $args)
  {
    $route = ['path' => '/api/{application}/user', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['application' => $application], $args);
    $requiredArguments = ['userName', 'email', 'password'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

}
