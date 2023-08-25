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
class ProjectRepository extends Repository  {

  /**
   * This endpoint will return a detailed onboarding status.
   *
   * @param project
   * @param {Object} args
   */
  public function getStatus($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/{project}/onboarding/status', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

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
  public function search(array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/projects/search', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['user'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all projects and the user roles for a given user.
   *
   * @param providerIdentifier
   * @param {Object} args
   */
  public function searchAll($providerIdentifier, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/{providerIdentifier}/all', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['providerIdentifier' => $providerIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Delete the given project.
   *
   * @param project
   * @param {Object} args
   */
  public function delete($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/projects/{project}', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Update the given project.
   *
   * @param project
   * @param {Object} args
   * @param {String} args.name 
   * @param {String} args.location The location the project should be monitored from (optional)
   */
  public function update($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/projects/{project}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['name'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all users for the given project.
   *
   * @param project
   * @param {Object} args
   */
  public function getUsers($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/users/{project}', 'method' => 'GET', 'version' =>  1];
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
  public function removeUser($project, $user, array $args = [])
  {
    $route = ['path' => '/kapi/v1/project/users/{project}/{user}', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

}
