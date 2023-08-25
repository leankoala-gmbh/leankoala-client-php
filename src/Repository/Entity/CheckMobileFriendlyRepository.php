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
class CheckMobileFriendlyRepository extends Repository  {

  /**
   * Get the mobile friendly result for the given system. Returns a "skipped" status if the test never
   * ran.
   *
   * @param system
   * @param {Object} args
   */
  public function getResults($system, array $args = [])
  {
    $route = ['path' => '/kapi/v1/check/checks/{system}/mobilefriendly', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

}
