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
class ProjectRepository extends Repository  {

  /**
   * Return all projects and the user roles for a given user.
   *
   * @param {Object} args
   * @param {Number} args.user The users id
   * @param {Boolean} args.with_next_full_run If true the next approximated hourly run will be returned;
   *                                          the value is the time in seconds till the next run (default: false)
   * @param {Boolean} args.with_onboarding_status If true the projects onboarding status is added to the
   *                                              response. (default: false)
   * @param {Boolean} args.with_features If true the projects marketplace features are added to the
   *                                     response. (default: false)
   * @param {Boolean} args.owned_by_user If true the only projects owned by this user are returned. (default: false)
   * @param {Boolean} args.filter_empty_projects If true the only projects with systems are returned (default: false)
   */
  public function search($args)
  {
    $route = ['path' => 'project/projects/search', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['user'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Update the given project.
   *
   * @param project
   * @param {Object} args
   * @param {String} args.name 
   */
  public function update($project, $args)
  {
    $route = ['path' => 'project/projects/{project}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['name'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Delete the given project.
   *
   * @param project
   * @param {Object} args
   */
  public function delete($project, $args)
  {
    $route = ['path' => 'project/projects/{project}', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all users for the given project.
   *
   * @param project
   * @param {Object} args
   */
  public function getUsers($project, $args)
  {
    $route = ['path' => 'project/users/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Remove a given user from the project.
   *
   * @param project
   * @param user
   * @param {Object} args
   */
  public function removeUser($project, $user, $args)
  {
    $route = ['path' => 'project/users/{project}/{user}', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint will return a detailed onboarding status.
   *
   * @param project
   * @param {Object} args
   */
  public function getStatus($project, $args)
  {
    $route = ['path' => 'project/{project}/onboarding/status', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

}
