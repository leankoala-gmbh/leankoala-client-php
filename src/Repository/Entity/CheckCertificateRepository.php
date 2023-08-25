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
class CheckCertificateRepository extends Repository  {

  /**
   * @param system
   * @param {Object} args
   */
  public function getExpirationResults($system, array $args = [])
  {
    $route = ['path' => '/kapi/v1/check/checks/{system}/certificate', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

}
