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
class LocationRepository extends Repository  {

  /**
   * Return the maximum number of components that can be added to the given system.
   * @param {Object} args
   */
  public function list(array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/location/list', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge([], $args);

    return $this->connection->send($route, $argList);
  }

}
