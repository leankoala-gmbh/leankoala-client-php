<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2021-06-14
 */
class UserRepository extends Repository implements \Leankoala\ApiClient\Repository\MasterConnectionRepository {

  /**
   * This endpoint creates a new user.
   *
   * @param application
   * @param {Object} args
   * @param {String} args.userName
   * @param {String} args.email
   * @param {String} args.password
   * @param {Number} args.company  (optional)
   * @param {String} args.fullName The users full name. (optional)
   * @param {String} args.firstName The users first name. (optional)
   * @param {String} args.lastName The users last name. (optional)
   * @param {Boolean} args.suppressActivation  (default: false)
   */
  public function createUser($application, $args)
  {
    $route = ['path' => '{application}/user', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['application' => $application], $args);
    $requiredArguments = ['userName', 'email', 'password'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint deletes a user.
   *
   * @param $application
   * @param $user
   * @param array $args
   */
  public function deleteUser($application, $user, $args = [])
  {
      $route = ['path' => '{application}/user/{user}', 'method' => 'DELETE', 'version' =>  1];
      $argList = array_merge(['application' => $application, 'user' => $user], $args);

      return $this->connection->send($route, $argList, false);
  }

  /**
   * This endpoint updates an existing user.
   *
   * @param application
   * @param user
   * @param {Object} args
   * @param {String} args.email The email address of the new user. (optional)
   * @param {String} args.preferred_language The users preferred interface language. (optional)
   * @param {Number} args.company_id The companies numeric id of the new user. (optional)
   * @param {String} args.first_name The users first name. (optional)
   * @param {String} args.last_name The users last name. (optional)
   */
  public function updateUser($application, $user, $args)
  {
    $route = ['path' => '{application}/user/{user}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['application' => $application, 'user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Update the users preferred language.
   *
   * @param application
   * @param user
   * @param {Object} args
   * @param {String} args.language The users preferred interface language.
   */
  public function setPreferredLanguage($application, $user, $args)
  {
    $route = ['path' => '{application}/user/{user}/language', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['application' => $application, 'user' => $user], $args);
    $requiredArguments = ['language'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Change the users password.
   *
   * @param application
   * @param user
   * @param {Object} args
   * @param {String} args.password_old
   * @param {String} args.password_new
   */
  public function changePassword($application, $user, $args)
  {
    $route = ['path' => '{application}/user/{user}/password', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['application' => $application, 'user' => $user], $args);
    $requiredArguments = ['password_old', 'password_new'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Checks if the user can be deleted.
   *
   * @param application
   * @param user
   * @param company
   * @param {Object} args
   */
  public function isDeletable($application, $user, $company, $args)
  {
    $route = ['path' => '{application}/user/{user}/deletable/{company}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['application' => $application, 'user' => $user, 'company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Reset the password.
   *
   * @param application
   * @param user
   * @param {Object} args
   * @param {String} args.password The new password
   */
  public function resetPassword($application, $user, $args)
  {
    $route = ['path' => '{application}/user/{user}/password/reset', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['application' => $application, 'user' => $user], $args);
    $requiredArguments = ['password'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Activate an user account. The endpoint will return a valid access and refresh token so the user can
   * be logged in without re-entering username and password.
   *
   * @param application
   * @param {Object} args
   * @param {String} args.activation_key
   */
  public function activate($application, $args)
  {
    $route = ['path' => '{application}/user/activate', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['application' => $application], $args);
    $requiredArguments = ['activation_key'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint returns a user that matches the given search criteria.
   *
   * @param application
   * @param {Object} args
   * @param {Array} args.query The key value pairs for the search.
   */
  public function find($application, $args)
  {
    $route = ['path' => '{application}/user/find', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['application' => $application], $args);
    $requiredArguments = ['query'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint connects an OAuth provider with the current user.
   *
   * @param application
   * @param user
   * @param {Object} args
   * @param {*} args.provider The OAuth provider.
   * @param {String} args.providerUserId The OAuth provider user id.
   */
  public function connectAuthAccount($application, $user, $args)
  {
    $route = ['path' => '{application}/user/{user}/connect', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['application' => $application, 'user' => $user], $args);
    $requiredArguments = ['provider', 'providerUserId'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

}
