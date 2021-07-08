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
class ScreenshotRepository extends Repository  {

  /**
   * Return the screenshots for a single component.
   *
   * @param system
   * @param {Object} args
   */
  public function getScreenshot($system, $args)
  {
    $route = ['path' => 'project/screenshot/{system}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the screenshots for all components in the given project.
   *
   * @param system
   * @param {Object} args
   */
  public function getSystemScreenshots($system, $args)
  {
    $route = ['path' => 'project/screenshots/{system}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

}
