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
class MarketplaceRepository extends Repository  {

  /**
   * Return all features that are active for the given provider.
   *
   * @param providerIdentifier
   * @param {Object} args
   */
  public function getActiveProviderFeatures($providerIdentifier, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/features/provider/{providerIdentifier}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['providerIdentifier' => $providerIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all features that are active for the given project.
   *
   * @param project
   * @param {Object} args
   */
  public function getActiveProjectFeatures($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/features/project/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all the status of the health checks of the systems components.
   *
   * @param system
   * @param {Object} args
   */
  public function getSystemPluginStatus($system, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/plugins/incidents/system/{system}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all the status of the health checks of the systems components.
   *
   * @param user
   * @param {Object} args
   */
  public function getUserPluginStatus($user, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/plugins/incidents/user/{user}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all component suggestions that are enabled by the active features.
   *
   * @param system
   * @param featureIdentifier
   * @param {Object} args
   */
  public function getComponents($system, $featureIdentifier, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/features/components/{system}/{featureIdentifier}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system, 'featureIdentifier' => $featureIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Set a component using a given suggestion as template.
   *
   * @param system
   * @param suggestionIdentifier
   * @param {Object} args
   * @param {String} args.url 
   */
  public function setComponent($system, $suggestionIdentifier, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/features/components/{system}/{suggestionIdentifier}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system, 'suggestionIdentifier' => $suggestionIdentifier], $args);
    $requiredArguments = ['url'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all features that can be activated for the given company and provider.
   *
   * @param providerIdentifier
   * @param company
   * @param {Object} args
   */
  public function getFeatures($providerIdentifier, $company, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/marketplace/features/{providerIdentifier}/{company}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['providerIdentifier' => $providerIdentifier, 'company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all features that are activated for the given project.
   *
   * @param project
   * @param {Object} args
   * @param {Number} args.status  (default: 400)
   */
  public function getAvailableFeatures($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/marketplace/feature/available/{project}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all features that exists.
   * @param {Object} args
   */
  public function getAllFeatures(array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/marketplace/feature/all', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return a list of features that where marked as favourites.
   * @param {Object} args
   */
  public function getFavourites(array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/marketplace/favourites', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge([], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all features that are activated for the given project.
   *
   * @param project
   * @param {Object} args
   */
  public function getActiveFeatures($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/marketplace/feature/active/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Activate the given feature for the given projects.
   *
   * @param company
   * @param featureIdentifier
   * @param {Object} args
   * @param {Array} args.projects 
   */
  public function activateFeature($company, $featureIdentifier, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/marketplace/feature/activate/{company}/{featureIdentifier}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company, 'featureIdentifier' => $featureIdentifier], $args);
    $requiredArguments = ['projects'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Deactivate the given feature for the given projects.
   *
   * @param company
   * @param featureIdentifier
   * @param {Object} args
   * @param {Array} args.projects 
   */
  public function deactivateFeature($company, $featureIdentifier, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/marketplace/feature/deactivate/{company}/{featureIdentifier}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company, 'featureIdentifier' => $featureIdentifier], $args);
    $requiredArguments = ['projects'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Show the booking logs for the company.
   *
   * @param company
   * @param {Object} args
   */
  public function getBookingLog($company, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/log/company/{company}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Proxy a REST request 
   *
   * @param secret
   * @param url
   * @param {Object} args
   */
  public function restProxy($secret, $url, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/proxy/{secret}/{url}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['secret' => $secret, 'url' => $url], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all the status of the health checks of the systems components.
   *
   * @param system
   * @param featureIdentifier
   * @param {Object} args
   * @param {String} args.from  (default: -1day)
   * @param {String} args.time  (default: 1h)
   */
  public function getHealthStatus($system, $featureIdentifier, array $args = [])
  {
    $route = ['path' => '/kapi/v1/marketplace/features/status/{system}/{featureIdentifier}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system, 'featureIdentifier' => $featureIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

}
