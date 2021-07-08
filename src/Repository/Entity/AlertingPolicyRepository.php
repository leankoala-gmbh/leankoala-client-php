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
class AlertingPolicyRepository extends Repository  {

  /**
   * List all policies for the given project
   *
   * @param project
   * @param {Object} args
   */
  public function list($project, $args)
  {
    $route = ['path' => 'alerting/policies/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * @param project
   * @param {Object} args
   * @param {String} args.name 
   * @param {String} args.interval  (default: immediately)
   * @param {Array} args.severities  (optional)
   * @param {Number} args.channels  (optional)
   */
  public function create($project, $args)
  {
    $route = ['path' => 'alerting/policies/{project}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['name'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Delete the given policy
   *
   * @param project
   * @param policy
   * @param {Object} args
   */
  public function delete($project, $policy, $args)
  {
    $route = ['path' => 'alerting/policies/{project}/{policy}', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'policy' => $policy], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * @param project
   * @param policy
   * @param {Object} args
   * @param {String} args.name  (optional)
   * @param {String} args.interval  (optional)
   * @param {Array} args.severities  (optional)
   * @param {Number} args.channels  (optional)
   */
  public function update($project, $policy, $args)
  {
    $route = ['path' => 'alerting/policies/{project}/{policy}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'policy' => $policy], $args);

    return $this->connection->send($route, $argList);
  }

}
