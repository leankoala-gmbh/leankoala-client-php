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
class ToolRepository extends Repository  {

  /**
   * Return all tools for the given project.
   *
   * @param project
   * @param {Object} args
   */
  public function findByProject($project, $args)
  {
    $route = ['path' => 'check/tools/{project}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

    /**
     * Get the tool configurations for all tools that changed.
     *
     * @param {Object} args
     * @param {Number} args.newerThan
     * @param {Boolean} args.minifyOutput  (default: false)
     */
    public function getChangedConfiguration($args)
    {
        $route = ['path' => 'check/tools/changed', 'method' => 'POST', 'version' =>  1];
        $argList = array_merge([], $args);
        $requiredArguments = ['newerThan'];
        $this->assertValidArguments($requiredArguments, $argList);

        return $this->connection->send($route, $argList);
    }

  /**
   * Get the tool configuration.
   *
   * @param project
   * @param toolIdentifier
   * @param {Object} args
   */
  public function getConfiguration($project, $toolIdentifier, $args)
  {
    $route = ['path' => 'check/tools/{project}/{toolIdentifier}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'toolIdentifier' => $toolIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Overwrite tool configuration.
   *
   * @param project
   * @param toolIdentifier
   * @param {Object} args
   * @param {Number} args.errors_in_a_row Number of errors in a row before marked as failure (optional)
   * @param {Number} args.success_in_a_row Number of successes in a row before marked as passed (optional)
   */
  public function overwrite($project, $toolIdentifier, $args)
  {
    $route = ['path' => 'check/tools/{project}/{toolIdentifier}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'toolIdentifier' => $toolIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

}
