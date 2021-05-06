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
class InvitationRepository extends Repository  {

  /**
   * This endpoint invites a new user to the project.
   *
   * @param project
   * @param {Object} args
   * @param {String} args.email The invitations e-mail address
   * @param {String} args.user_name The users company name. (default: )
   * @param {Number} args.user_role The projects role of the newly added user.
   * @param {Number} args.inviter The inviters user id.
   */
  public function invite($project, $args)
  {
    $route = ['path' => 'user/invitation/invite/{project}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['email', 'user_role', 'inviter'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint aborts a given invitation.
   *
   * @param invitation
   * @param {Object} args
   */
  public function abort($invitation, $args)
  {
    $route = ['path' => 'user/invitation/abort/{invitation}', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge(['invitation' => $invitation], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint returns a list of all open invitations for the given project.
   *
   * @param project
   * @param {Object} args
   */
  public function getOpenInvitations($project, $args)
  {
    $route = ['path' => 'user/invitation/open/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

}
