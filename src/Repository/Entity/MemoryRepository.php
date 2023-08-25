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
class MemoryRepository extends Repository  {

  /**
   * @param objectType
   * @param objectId
   * @param {Object} args
   * @param {String} args.key 
   * @param {String} args.value 
   */
  public function set($objectType, $objectId, array $args = [])
  {
    $route = ['path' => '/kapi/v1/memory/{objectType}/{objectId}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['objectType' => $objectType, 'objectId' => $objectId], $args);
    $requiredArguments = ['key', 'value'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * @param objectType
   * @param objectId
   * @param {Object} args
   */
  public function getAll($objectType, $objectId, array $args = [])
  {
    $route = ['path' => '/kapi/v1/memory/{objectType}/{objectId}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['objectType' => $objectType, 'objectId' => $objectId], $args);

    return $this->connection->send($route, $argList);
  }

}
