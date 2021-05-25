<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2021-05-25
 */
class MemoryRepository extends Repository  {

  /**
   * Write something to the memory
   *
   * @param application
   * @param objectType
   * @param objectId
   * @param {Object} args
   * @param {String} args.key 
   * @param {String} args.value 
   */
  public function set($application, $objectType, $objectId, $args)
  {
    $route = ['path' => '/{application}/memory/{objectType}/{objectId}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['application' => $application, 'objectType' => $objectType, 'objectId' => $objectId], $args);
    $requiredArguments = ['key', 'value'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

}
