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
class SequenceRepository extends Repository  {

  /**
   * Get a list of possible commands
   *
   * @param project
   * @param {Object} args
   */
  public function getCommands($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/sequences/{project}/commands', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Get a list of possible commands
   *
   * @param project
   * @param {Object} args
   */
  public function getSequences($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/sequences/{project}/sequences', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Create a new sequence.
   *
   * @param project
   * @param {Object} args
   * @param {String} args.name The human readable name of the sequence.
   * @param {String} args.startUrl The url the sequence starts at.
   * @param {Array} args.steps List of steps of the sequence. (optional)
   */
  public function createSequence($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/sequences/{project}/sequence', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['name', 'startUrl'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Update an existing sequence
   *
   * @param project
   * @param {Object} args
   * @param {String} args.name The human readable name of the sequence. (optional)
   * @param {String} args.startUrl The url the sequence starts at. (optional)
   * @param {Array} args.steps List of steps of the sequence. (optional)
   */
  public function updateSequence($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/sequences/{project}/sequence', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Activate an existing sequence.
   *
   * @param sequence
   * @param {Object} args
   */
  public function activateSequence($sequence, array $args = [])
  {
    $route = ['path' => '/kapi/v1/sequences/{sequence}/activate', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['sequence' => $sequence], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Deactivate an existing sequence.
   *
   * @param sequence
   * @param {Object} args
   */
  public function deactivateSequence($sequence, array $args = [])
  {
    $route = ['path' => '/kapi/v1/sequences/{sequence}/deactivate', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['sequence' => $sequence], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return a list of recent runs.
   *
   * @param sequence
   * @param {Object} args
   */
  public function getRecentRuns($sequence, array $args = [])
  {
    $route = ['path' => '/kapi/v1/sequences/{sequence}/recent', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['sequence' => $sequence], $args);

    return $this->connection->send($route, $argList);
  }

}
