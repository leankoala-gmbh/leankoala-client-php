<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2021-05-05
 */
class Auth2ApplicationRepository extends Repository {

  /**
   * @param {Object} args
   * @param {String} args.name 
   * @param {String} args.identifier 
   */
  public function createApplication($args)
  {
    $route = ['path' => '/api/application', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['name', 'identifier'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * @param application
   * @param {Object} args
   */
  public function getPrimaryCluster($application, $args)
  {
    $route = ['path' => '/api/{application}/cluster/primary', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['application' => $application], $args);

    return $this->connection->send($route, $argList);
  }

}
