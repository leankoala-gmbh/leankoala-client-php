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
class UserRepository extends Repository  {

  /**
   * Activate an user account. The endpoint will return a valid access and refresh token so the user can
   * be logged in without re-entering username and password.
   *
   * @param {Object} args
   * @param {String} args.activation_key 
   */
  public function activate($args)
  {
    $route = ['path' => 'user/users/activate', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['activation_key'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint creates a new user. The given provider (url param) will be attached.
   *
   * @param provider
   * @param {Object} args
   * @param {String} args.username The new users name. (optional)
   * @param {Boolean} args.suppress_activation If true no activation mail will be send.. (default: false)
   * @param {String} args.email The email address of the new user.
   * @param {String} args.preferred_language The users preferred interface language. (optional)
   * @param {Number} args.company_id The companies numeric id of the new user. (optional)
   * @param {Boolean} args.create_company Create a new company if none exists. (default: false)
   * @param {String} args.full_name The users full name. (optional)
   * @param {String} args.first_name The users first name. (optional)
   * @param {String} args.last_name The users last name. (optional)
   * @param {String} args.password 
   */
  public function create($provider, $args)
  {
    $route = ['path' => 'user/users/{provider}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['provider' => $provider], $args);
    $requiredArguments = ['email', 'password'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint updates an existing user.
   *
   * @param user
   * @param {Object} args
   * @param {String} args.email The email address of the new user. (optional)
   * @param {String} args.preferred_language The users preferred interface language. (optional)
   * @param {Number} args.company_id The companies numeric id of the new user. (optional)
   * @param {String} args.first_name The users first name. (optional)
   * @param {String} args.last_name The users last name. (optional)
   */
  public function updateUser($user, $args)
  {
    $route = ['path' => 'user/users/{user}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Update the users preferred language.
   *
   * @param user
   * @param {Object} args
   * @param {String} args.language The users preferred interface language.
   */
  public function setPreferredLanguage($user, $args)
  {
    $route = ['path' => 'user/users/preferredLanguage/{user}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['language'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Delete the given user and all owned projects.
   *
   * @param user
   * @param {Object} args
   */
  public function delete($user, $args)
  {
    $route = ['path' => 'user/users/{user}', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Checks if the user can be deleted.
   *
   * @param user
   * @param {Object} args
   */
  public function isDeletable($user, $args)
  {
    $route = ['path' => 'user/users/deletable/{user}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   *  the given user (by email) and all owned projects.
   *
   * @param {Object} args
   * @param {String} args.email The users email address
   */
  public function deleteByEmail($args)
  {
    $route = ['path' => 'user/users/delete/email', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['email'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint connects an OAuth provider with the current user.
   *
   * @param user
   * @param {Object} args
   * @param {*} args.provider The OAuth provider.
   * @param {String} args.provider_user_id The OAuth provider user id.
   */
  public function connectOAuthAccount($user, $args)
  {
    $route = ['path' => 'user/oauth/{user}/connect', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['provider', 'provider_user_id'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint returns true if a user exists that matches the given search criteria.
   *
   * @param {Object} args
   * @param {Array} args.query The key value pairs for the search.
   */
  public function exists($args)
  {
    $route = ['path' => 'user/users/exists', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['query'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint returns a user that matches the given search criteria.
   *
   * @param {Object} args
   * @param {Array} args.query The key value pairs for the search.
   */
  public function find($args)
  {
    $route = ['path' => 'user/users/find', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['query'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Change the users password.
   *
   * @param user
   * @param {Object} args
   * @param {String} args.password_old 
   * @param {String} args.password_new 
   */
  public function changePassword($user, $args)
  {
    $route = ['path' => 'user/users/{user}/password', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['password_old', 'password_new'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Request password change e-mail.
   *
   * @param {Object} args
   * @param {String} args.email The users email address
   */
  public function requestPasswordReset($args)
  {
    $route = ['path' => 'user/users/password/reset/request', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['email'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Reset the password.
   *
   * @param user
   * @param {Object} args
   * @param {String} args.password The new password
   */
  public function resetPassword($user, $args)
  {
    $route = ['path' => 'user/users/password/reset/{user}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['password'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Update the subscription for a given user.
   *
   * @param user
   * @param {Object} args
   * @param {Number} args.system_count The number of systems the user is allowed to create.
   */
  public function update($user, $args)
  {
    $route = ['path' => 'user/subscriptions/{user}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['system_count'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

}
