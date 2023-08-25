<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2023-08-25
 */
class NixstatsRepository extends Repository  {

  /**
   * Create a new 360 website monitor.
   *
   * @param company
   * @param {Object} args
   * @param {String} args.url 
   */
  public function createWebsiteMonitor($company, array $args = [])
  {
    $route = ['path' => '/kapi/v1/check/nixtstats/{company}/monitor/website', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);
    $requiredArguments = ['url'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

}
