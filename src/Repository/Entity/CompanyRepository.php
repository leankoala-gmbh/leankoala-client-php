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
class CompanyRepository extends Repository  {

  /**
   * Create a new company
   *
   * @param providerIdentifier
   * @param {Object} args
   * @param {String} args.name The companies name
   */
  public function create($providerIdentifier, $args)
  {
    $route = ['path' => 'user/companies/{providerIdentifier}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['providerIdentifier' => $providerIdentifier], $args);
    $requiredArguments = ['name'];
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

}
