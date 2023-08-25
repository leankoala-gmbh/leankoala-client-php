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
class CheckRepository extends Repository  {

  /**
   * @param {Object} args
   * @param {Number} args.component 
   * @param {Number} args.cookbook 
   */
  public function addByRecipe(array $args = [])
  {
    $route = ['path' => '/kapi/v1/check/checks/cookbook', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['component', 'cookbook'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * @param system
   * @param {Object} args
   * @param {*} args.checklist 
   * @param {Boolean} args.clear_before  (default: true)
   * @param {Boolean} args.activate_checks  (default: false)
   */
  public function addByChecklist($system, array $args = [])
  {
    $route = ['path' => '/kapi/v1/check/checks/{system}/checklist', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);
    $requiredArguments = ['checklist'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Run checks defined by tool identifier for all components within this system.
   *
   * @param system
   * @param toolIdentifier
   * @param {Object} args
   */
  public function runChecksForSystem($system, $toolIdentifier, array $args = [])
  {
    $route = ['path' => '/kapi/v1/check/checks/run/{system}/{toolIdentifier}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system, 'toolIdentifier' => $toolIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return a list of collections for the given project.
   *
   * @param project
   * @param toolIdentifier
   * @param {Object} args
   * @param {String} args.group The collection group. It is used to specify the collections. (default: )
   */
  public function showCollections($project, $toolIdentifier, array $args = [])
  {
    $route = ['path' => '/kapi/v1/check/collections/{project}/{toolIdentifier}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'toolIdentifier' => $toolIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return a list of active collections for the given system.
   *
   * @param system
   * @param toolIdentifier
   * @param {Object} args
   * @param {String} args.group The collection group. It is used to specify the collections. (default: )
   */
  public function showActiveCollections($system, $toolIdentifier, array $args = [])
  {
    $route = ['path' => '/kapi/v1/check/collections/system/active/{system}/{toolIdentifier}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system, 'toolIdentifier' => $toolIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Update the collections. WARNING: will delete the current collection connections and create new.
   *
   * @param system
   * @param {Object} args
   * @param {Array} args.collections  (optional)
   * @param {String} args.group The collection group. It is used to specify the collections. (default: )
   */
  public function updateCollections($system, array $args = [])
  {
    $route = ['path' => '/kapi/v1/check/collections/system/{system}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

}
