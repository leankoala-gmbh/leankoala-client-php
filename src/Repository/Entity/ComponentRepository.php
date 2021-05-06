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
class ComponentRepository extends Repository  {

  /**
   * Show all existing component types.
   *
   * @param project
   * @param {Object} args
   */
  public function showComponentTypes($project, $args)
  {
    $route = ['path' => 'project/components/componenttypes/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Get all information about the given component.
   *
   * @param component
   * @param {Object} args
   */
  public function showComponents($component, $args)
  {
    $route = ['path' => 'project/components/{component}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['component' => $component], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Create a new component.
   *
   * @param {Object} args
   * @param {Number} args.system 
   * @param {Boolean} args.enableToolsBySystem  (default: true)
   */
  public function createComponent($args)
  {
    $route = ['path' => 'project/components', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['system'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Create a set of new components for a given system.
   *
   * @param {Object} args
   * @param {Number} args.system The system the components are part of,
   * @param {Boolean} args.enableToolsBySystem If true all checks from the parent system are inherited. (default: true)
   * @param {Boolean} args.updateIfComponentSuggestionExists If true and a component with the same
   *                                                         suggestion id already exists it will be
   *                                                         updated. (default: false)
   * @param {Array} args.components List of components that should be created/updated.
   */
  public function createComponents($args)
  {
    $route = ['path' => 'project/components/many', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['system', 'components'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Update the given component.
   *
   * @param component
   * @param {Object} args
   */
  public function updateComponent($component, $args)
  {
    $route = ['path' => 'project/components/{component}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['component' => $component], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Mark the given component as deleted.
   *
   * @param component
   * @param {Object} args
   */
  public function deleteComponent($component, $args)
  {
    $route = ['path' => 'project/components/{component}', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge(['component' => $component], $args);

    return $this->connection->send($route, $argList);
  }

}
