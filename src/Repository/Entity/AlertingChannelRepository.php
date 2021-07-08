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
class AlertingChannelRepository extends Repository  {

  /**
   * List all channels for the given project.
   *
   * @param project
   * @param {Object} args
   */
  public function list($project, $args)
  {
    $route = ['path' => 'alerting/channels/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Create a new notification channel. At the moment only e-mail is provided.
   *
   * @param project
   * @param {Object} args
   * @param {String} args.name The name of the alert channel
   * @param {*} args.type 
   * @param {Array} args.options 
   * @param {String} args.language The language the alert should be send in. If not value is set the
   *                               default provider language is taken. (optional)
   */
  public function create($project, $args)
  {
    $route = ['path' => 'alerting/channels/{project}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['name', 'type', 'options'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Delete the given channel.
   *
   * @param project
   * @param channel
   * @param {Object} args
   */
  public function delete($project, $channel, $args)
  {
    $route = ['path' => 'alerting/channels/{project}/{channel}', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'channel' => $channel], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Update an existing notification channel.
   *
   * @param project
   * @param channel
   * @param {Object} args
   * @param {String} args.name  (optional)
   * @param {*} args.type 
   * @param {Array} args.options  (optional)
   * @param {String} args.language The language the alert should be send in (optional)
   */
  public function update($project, $channel, $args)
  {
    $route = ['path' => 'alerting/channels/{project}/{channel}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'channel' => $channel], $args);
    $requiredArguments = ['type'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

}
