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
class CheckDeadLinksRepository extends Repository  {

  /**
   * Return a list of dead links for every component attached to the given system.
   *
   * @param system
   * @param {Object} args
   */
  public function getResults($system, $args)
  {
    $route = ['path' => 'check/checks/{system}/deadlinks', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return a list of dead links for every component in every project owned by the company.
   *
   * @param company
   * @param {Object} args
   */
  public function getResultsByCompany($company, $args)
  {
    $route = ['path' => 'check/checks/company/{company}/deadlinks', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the dead link check configuration for the given system.
   *
   * @param system
   * @param {Object} args
   */
  public function getConfiguration($system, $args)
  {
    $route = ['path' => 'check/checks/{system}/deadlinks/config', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Add a new ignore pattern to the configuration.
   *
   * @param system
   * @param {Object} args
   * @param {Array} args.patterns List of URLs (strings) that will be excluded from the dead link crawl
   */
  public function ignorePattern($system, $args)
  {
    $route = ['path' => 'check/checks/{system}/deadlinks/ignore', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);
    $requiredArguments = ['patterns'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Remove an ignore pattern from the configuration.
   *
   * @param system
   * @param {Object} args
   * @param {Number} args.pattern_id Single URL that will not be excluded anymore in the dead link crawl
   */
  public function unignorePattern($system, $args)
  {
    $route = ['path' => 'check/checks/{system}/deadlinks/unignore', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);
    $requiredArguments = ['pattern_id'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

}
