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
class CheckBrokenResourceRepository extends Repository  {

  /**
   * @param system
   * @param {Object} args
   */
  public function getBrokenResources($system, $args)
  {
    $route = ['path' => 'check/checks/{system}/brokenresources', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

}
