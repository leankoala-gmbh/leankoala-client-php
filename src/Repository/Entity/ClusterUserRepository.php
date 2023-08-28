<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2023-08-28
 */
class ClusterUserRepository extends Repository  {

  /**
   * Activate an user account. The endpoint will return a valid access and refresh token so the user can
   * be logged in without re-entering username and password.
   *
   * @param {Object} args
   * @param {String} args.activation_key 
   */
  public function activate(array $args = [])
  {
    $route = ['path' => 'user/users/activate', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['activation_key'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Activate a user account by provider admin.
   *
   * @param provider
   * @param {Object} args
   * @param {Number} args.master_id The master_id user.
   */
  public function provider_activate($provider, array $args = [])
  {
    $route = ['path' => 'user/users/{provider}/activate', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['provider' => $provider], $args);
    $requiredArguments = ['master_id'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint creates a new user. The given provider (url param) will be attached.
   *
   * @param provider
   * @param {Object} args
   * @param {String} args.username The new users name. (optional)
   * @param {Number} args.master_id The users id on the master server. (default: -1)
   * @param {Boolean} args.suppress_activation If true no activation mail will be send.. (default: false)
   * @param {Boolean} args.activate If true no activation mail will be send.. (default: true)
   * @param {String} args.email The email address of the new user.
   * @param {String} args.preferred_language The users preferred interface language. (optional)
   * @param {Number} args.company_id The companies numeric id of the new user. (optional)
   * @param {Boolean} args.create_company Create a new company if none exists. (default: false)
   * @param {String} args.full_name The users full name. (optional)
   * @param {String} args.first_name The users first name. (optional)
   * @param {String} args.last_name The users last name. (optional)
   * @param {String} args.password 
   * @param {Array} args._attributes Additional attributes for the user (default: [])
   */
  public function create($provider, array $args = [])
  {
    $route = ['path' => 'user/users/{provider}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['provider' => $provider], $args);
    $requiredArguments = ['email', 'password'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Update the users preferred language.
   *
   * @param user
   * @param {Object} args
   * @param {String} args.language The users preferred interface language.
   */
  public function setPreferredLanguage($user, array $args = [])
  {
    $route = ['path' => 'user/users/preferredLanguage/{user}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['language'];
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
  public function connectOAuthAccount($user, array $args = [])
  {
    $route = ['path' => 'user/oauth/{user}/connect', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['provider', 'provider_user_id'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Change the users password. This can only be done by the master server.
   *
   * @param user
   * @param {Object} args
   * @param {String} args.password_new 
   */
  public function changePassword($user, array $args = [])
  {
    $route = ['path' => 'user/users/{user}/password', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['password_new'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint returns true if a user exists that matches the given search criteria.
   *
   * @param {Object} args
   * @param {Array} args.query The key value pairs for the search.
   */
  public function exists(array $args = [])
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
  public function find(array $args = [])
  {
    $route = ['path' => 'user/users/find', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['query'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Delete the given user and all owned projects.
   *
   * @param user
   * @param {Object} args
   */
  public function delete($user, array $args = [])
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
  public function isDeletable($user, array $args = [])
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
  public function deleteByEmail(array $args = [])
  {
    $route = ['path' => 'user/users/delete/email', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['email'];
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
  public function updateUser($user, array $args = [])
  {
    $route = ['path' => 'user/users/{user}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * This endpoint updates an existing users master id.
   *
   * @param user
   * @param {Object} args
   * @param {Number} args.master_id The users master id.
   */
  public function updateMasterId($user, array $args = [])
  {
    $route = ['path' => 'user/users/{user}/masterId', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['master_id'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Request password change e-mail.
   *
   * @param {Object} args
   * @param {String} args.email The users email address
   */
  public function requestPasswordReset(array $args = [])
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
  public function resetPassword($user, array $args = [])
  {
    $route = ['path' => 'user/users/password/reset/{user}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['password'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return a list of all users for the given company.
   *
   * @param providerIdentifier
   * @param {Object} args
   */
  public function findAll($providerIdentifier, array $args = [])
  {
    $route = ['path' => 'user/users/find/all/{providerIdentifier}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['providerIdentifier' => $providerIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

}
