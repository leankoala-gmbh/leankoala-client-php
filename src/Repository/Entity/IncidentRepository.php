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
class IncidentRepository extends Repository  {

  /**
   * Find all open incidents for the given project. Optionally it can be filtered by system.
   *
   * @param project
   * @param {Object} args
   * @param {Number} args.system the system filter (optional)
   */
  public function search($project, $args)
  {
    $route = ['path' => 'incident/incidents/{project}/search', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Find all incidents that where open in the last days.
   *
   * @param project
   * @param {Object} args
   * @param {Number} args.days The number of days the incidents can old
   */
  public function since($project, $args)
  {
    $route = ['path' => 'incident/incidents/{project}/since', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['days'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Find a single incident by id
   *
   * @param project
   * @param incident
   * @param {Object} args
   */
  public function find($project, $incident, $args)
  {
    $route = ['path' => 'incident/incidents/{project}/{incident}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'incident' => $incident], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint returns the the configuration (errors_in_a_row, success_in_a_row) of all tools in the
   * given project. It also handles tool inheritance.
   *
   * @param project
   * @param {Object} args
   */
  public function getConfig($project, $args)
  {
    $route = ['path' => 'incident/tools/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

}
