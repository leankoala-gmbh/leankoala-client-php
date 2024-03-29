<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2021-11-21
 */
class InvitationRepository extends Repository  {

  /**
   * This endpoint invites a new user to the project.
   *
   * @param $project
   * @param array $args
   * @param {String} args.email The invitations e-mail address
   * @param {String} args.user_name The users company name. (default: )
   * @param {Integer} args.user_role The projects role of the newly added user. (default: 200)
   */
  public function invite($project, array $args)
  {
    $route = ['path' => 'user/invitation/invite/{project}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['email'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint aborts a given invitation.
   *
   * @param $invitation
   * @param array $args
   */
  public function abort($invitation, array $args)
  {
    $route = ['path' => 'user/invitation/abort/{invitation}', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge(['invitation' => $invitation], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint returns a list of all open invitations for the given project.
   *
   * @param $project
   * @param array $args
   */
  public function getOpenInvitations($project, array $args)
  {
    $route = ['path' => 'user/invitation/open/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

}
