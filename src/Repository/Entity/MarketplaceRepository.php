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
class MarketplaceRepository extends Repository  {

  /**
   * Return all features that are active for the given project.
   *
   * @param project
   * @param {Object} args
   */
  public function getActiveProjectFeatures($project, $args)
  {
    $route = ['path' => 'marketplace/features/project/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all features that are active for the given provider.
   *
   * @param providerIdentifier
   * @param {Object} args
   */
  public function getActiveProviderFeatures($providerIdentifier, $args)
  {
    $route = ['path' => 'marketplace/features/provider/{providerIdentifier}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['providerIdentifier' => $providerIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all component suggestions that are enabled by the active features.
   *
   * @param system
   * @param featureIdentifier
   * @param {Object} args
   */
  public function getComponents($system, $featureIdentifier, $args)
  {
    $route = ['path' => 'marketplace/features/components/{system}/{featureIdentifier}', 'method' => 'GET', 'version' =>  1];
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
  public function setComponent($system, $suggestionIdentifier, $args)
  {
    $route = ['path' => 'marketplace/features/components/{system}/{suggestionIdentifier}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['system' => $system, 'suggestionIdentifier' => $suggestionIdentifier], $args);
    $requiredArguments = ['url'];
    $this->assertValidArguments($requiredArguments, $argList);

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
  public function getHealthStatus($system, $featureIdentifier, $args)
  {
    $route = ['path' => 'marketplace/features/status/{system}/{featureIdentifier}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['system' => $system, 'featureIdentifier' => $featureIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all features that can be activated for the given company and provider.
   *
   * @param providerIdentifier
   * @param company
   * @param {Object} args
   */
  public function getFeatures($providerIdentifier, $company, $args)
  {
    $route = ['path' => 'marketplace/marketplace/features/{providerIdentifier}/{company}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['providerIdentifier' => $providerIdentifier, 'company' => $company], $args);

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
  public function activateFeature($company, $featureIdentifier, $args)
  {
    $route = ['path' => 'marketplace/marketplace/feature/activate/{company}/{featureIdentifier}', 'method' => 'POST', 'version' =>  1];
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
  public function deactivateFeature($company, $featureIdentifier, $args)
  {
    $route = ['path' => 'marketplace/marketplace/feature/deactivate/{company}/{featureIdentifier}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company, 'featureIdentifier' => $featureIdentifier], $args);
    $requiredArguments = ['projects'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all features that are activated for the given project.
   *
   * @param project
   * @param {Object} args
   */
  public function getActiveFeatures($project, $args)
  {
    $route = ['path' => 'marketplace/marketplace/feature/active/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all features that are activated for the given project.
   *
   * @param project
   * @param {Object} args
   * @param {Number} args.status  (default: 400)
   */
  public function getAvailableFeatures($project, $args)
  {
    $route = ['path' => 'marketplace/marketplace/feature/available/{project}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all features that exists.
   * @param {Object} args
   */
  public function getAllFeatures($args)
  {
    $route = ['path' => 'marketplace/marketplace/feature/all', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return a list of features that where marked as favourites.
   * @param {Object} args
   */
  public function getFavourites($args)
  {
    $route = ['path' => 'marketplace/marketplace/favourites', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge([], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Show the booking logs for the company.
   *
   * @param company
   * @param {Object} args
   */
  public function getBookingLog($company, $args)
  {
    $route = ['path' => 'marketplace/log/company/{company}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

}
