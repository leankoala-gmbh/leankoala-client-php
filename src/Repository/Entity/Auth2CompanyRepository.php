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
class Auth2CompanyRepository extends Repository {

  /**
   * @param application
   * @param company
   * @param {Object} args
   * @param {Number} args.cluster 
   */
  public function setCluster($application, $company, $args)
  {
    $route = ['path' => '/api/{application}/company/{company}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['application' => $application, 'company' => $company], $args);
    $requiredArguments = ['cluster'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

}
