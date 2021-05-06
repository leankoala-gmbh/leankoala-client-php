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
class ScoreRepository extends Repository  {

  /**
   * Return a list of scores by the given score names for all projects and systems the user is part of.
   *
   * @param user
   * @param {Object} args
   * @param {Array} args.scores List of score names
   * @param {Boolean} args.with_sub_scores NOT IMPLEMENTED YET: If true detailed information about the
   *                                       score will be provided. (default: false)
   * @param {Boolean} args.filter_empty_projects If true the only projects with systems are returned (default: false)
   */
  public function getScoresByUser($user, $args)
  {
    $route = ['path' => 'score/scores/user/{user}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['scores'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the score for a given score name.
   *
   * @param system
   * @param scoreName
   * @param {Object} args
   */
  public function getScore($system, $scoreName, $args)
  {
    $route = ['path' => 'score/scores/{system}/{scoreName}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system, 'scoreName' => $scoreName], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return a list of scores by the given score names.
   *
   * @param system
   * @param {Object} args
   * @param {Array} args.scores list of score names
   */
  public function getScores($system, $args)
  {
    $route = ['path' => 'score/scores/{system}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);
    $requiredArguments = ['scores'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

}
