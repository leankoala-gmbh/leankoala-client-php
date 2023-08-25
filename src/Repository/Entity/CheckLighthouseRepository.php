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
class CheckLighthouseRepository extends Repository  {

  /**
   * Return all current lighthouse results for the given systems components.
   *
   * @param system
   * @param category
   * @param {Object} args
   * @param {*} args.targetGroup The target group. It can be either an integer or a string. (default: 2000)
   * @param {Boolean} args.use_cache Use the cache for json document fetch (default: true)
   */
  public function getResults($system, $category, array $args = [])
  {
    $route = ['path' => '/kapi/v1/check/checks/{system}/lighthouse/results/{category}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system, 'category' => $category], $args);

    return $this->connection->send($route, $argList);
  }

}
