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
class CheckCookieRepository extends Repository  {

  /**
   * This endpoint returns a list of domains that set cookies for the given system. As array elements it
   * adds the components on that the domain sets the cookies. IMPORTANT: The leankoala worker is blocking
   * some tracking integrations. So there will never be, for example, a Google Analytics cookie set.
   *
   * @param system
   * @param {Object} args
   */
  public function getDomains($system, array $args = [])
  {
    $route = ['path' => '/kapi/v1/check/checks/{system}/cookies/domains', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

}
