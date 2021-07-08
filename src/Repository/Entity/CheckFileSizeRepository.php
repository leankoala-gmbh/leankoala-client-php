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
class CheckFileSizeRepository extends Repository  {

  /**
   * @param system
   * @param {Object} args
   */
  public function getResults($system, $args)
  {
    $route = ['path' => 'check/checks/{system}/performance/big', 'method' => 'GET', 'version' =>  1];
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
    $route = ['path' => 'check/checks/{system}/siteinfo/ignore', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);
    $requiredArguments = ['patterns'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

}
