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
class SystemRepository extends Repository  {

  /**
   * Create a new system.
   *
   * @param {Object} args
   * @param {Number} args.project The project the system should be part of. If the project is not set a
   *                               new project will be created with the systems name. (optional)
   * @param {Boolean} args.add_standard_alerting If true add a standard channel and alerting policy for
   *                                             the owner. (default: false)
   * @param {String} args.name The shops name.
   * @param {Url} args.base_url The shops base url with scheme, subdomain and domain.
   * @param {Number} args.owner The shops owner (id).
   * @param {Number} args.system_type The shops system type (id).
   * @param {Number} args.system_size The system size id (optional)
   * @param {Boolean} args.add_checklist_checks If true all checks of the checklist connected to the main
   *                                            system type are added. (default: true)
   * @param {Boolean} args.add_support_user Add the support user for support requests (default: true)
   * @param {String} args.location Connect the system to a location (default: koalamon)
   */
  public function createSystem(array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/systems/system', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['name', 'base_url', 'owner', 'system_type'];
    $this->assertValidArguments($requiredArguments, $argList);

    $result = $this->connection->send($route, $argList);
    $this->connection->refreshAccessToken(true);
    return $result;
  }

  /**
   * Update an existing system.
   *
   * @param system
   * @param {Object} args
   * @param {String} args.name The shops name. (optional)
   * @param {Number} args.system_size The system size id (optional)
   * @param {Url} args.base_url The shops base url with scheme, subdomain and domain. (optional)
   */
  public function updateSystem($system, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/systems/system/{system}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all components for the given system.
   *
   * @param system
   * @param {Object} args
   */
  public function getComponents($system, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/systems/{system}/components', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all system types for the given provider.
   *
   * @param providerIdentifier
   * @param system
   * @param {Object} args
   * @param {Number} args.system_size The system size id (optional)
   */
  public function getSystemTypes($providerIdentifier, $system, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/systems/{providerIdentifier}/systemType/{system}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['providerIdentifier' => $providerIdentifier, 'system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all suggested component types for the given system.
   *
   * @param system
   * @param {Object} args
   */
  public function getComponentSuggestions($system, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/systems/{system}/suggestions', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Set the last full run timestamp on a system.
   *
   * @param system
   * @param status
   * @param {Object} args
   */
  public function changeLastFullRun($system, $status, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/systems/{system}/lastFullRun/{status}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system, 'status' => $status], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Trigger the component finder for a given system.
   *
   * @param project
   * @param system
   * @param user
   * @param {Object} args
   */
  public function triggerComponentFinder($project, $system, $user, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/{project}/componentfinder/{system}/{user}/trigger', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'system' => $system, 'user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the approximated time in seconds when the next full check run is triggered.
   *
   * @param system
   * @param {Object} args
   */
  public function getNextLastFullRun($system, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/systems/{system}/nextFullRun', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the maximum number of components that can be added to the given system.
   *
   * @param system
   * @param {Object} args
   */
  public function getComponentLimit($system, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/systems/{system}/component/limit', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

}
