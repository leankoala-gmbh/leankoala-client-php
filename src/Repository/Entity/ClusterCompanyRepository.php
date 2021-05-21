<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2021-05-20
 */
class ClusterCompanyRepository extends Repository  {

  /**
   * Create a new company
   *
   * @param providerIdentifier
   * @param {Object} args
   * @param {String} args.name The companies name
   * @param {Number} args.master_id The master id from the auth2 server
   */
  public function create($providerIdentifier, $args)
  {
    $route = ['path' => 'user/companies/{providerIdentifier}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['providerIdentifier' => $providerIdentifier], $args);
    $requiredArguments = ['name', 'master_id'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Check if the given company name already exists
   *
   * @param {Object} args
   * @param {String} args.company_name The companies name
   */
  public function exists($args)
  {
    $route = ['path' => 'user/companies/exists', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['company_name'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Search for a given company by provider and name
   *
   * @param providerIdentifier
   * @param {Object} args
   * @param {String} args.company_name The companies name
   */
  public function search($providerIdentifier, $args)
  {
    $route = ['path' => 'user/companies/search/{providerIdentifier}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['providerIdentifier' => $providerIdentifier], $args);
    $requiredArguments = ['company_name'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

    /**
     * Connect a given user to a company
     *
     * @param company
     * @param user
     * @param {Object} args
     * @param {String} args.user_role The users company role (default: employee)
     */
    public function connectUser($company, $user, $args)
    {
        $route = ['path' => 'user/companies/connect/{company}/{user}', 'method' => 'POST', 'version' =>  1];
        $argList = array_merge(['company' => $company, 'user' => $user], $args);

        return $this->connection->send($route, $argList);
    }
}
