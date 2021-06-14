<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2021-06-14
 */
class CompanyRepository extends Repository implements \Leankoala\ApiClient\Repository\MasterConnectionRepository {

  /**
   * Disconnect the user from the company.
   *
   * @param application
   * @param company
   * @param user
   * @param {Object} args
   * @param {Boolean} args.deleteIfNoCompany  (default: false)
   */
  public function disconnectUser($application, $company, $user, $args)
  {
    $route = ['path' => '/v1/{application}/company/{company}/disconnect/{user}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['application' => $application, 'company' => $company, 'user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

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
