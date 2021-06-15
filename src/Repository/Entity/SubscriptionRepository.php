<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2021-06-15
 */
class SubscriptionRepository extends Repository  {

  /**
   * Get the companies subscription information.
   *
   * @param company
   * @param {Object} args
   */
  public function getCompanySubscription($company, $args)
  {
    $route = ['path' => 'subscription/company/{company}/', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Set the companies credit card plans.
   *
   * @param company
   * @param {Object} args
   * @param {Number} args.quantity The number of packets to be used
   */
  public function setCompanyCreditCardPlans($company, $args)
  {
    $route = ['path' => 'subscription/company/{company}/plans/creditcard', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);
    $requiredArguments = ['quantity'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Set the companies free plans.
   *
   * @param company
   * @param {Object} args
   * @param {Number} args.quantity The number of packets to be used
   */
  public function setCompanyFreePlans($company, $args)
  {
    $route = ['path' => 'subscription/company/{company}/plans/free', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);
    $requiredArguments = ['quantity'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Set the companies credit card.
   *
   * @param company
   * @param {Object} args
   * @param {*} args.stripe_cc_source The stripe credit card id
   * @param {String} args.last_digits The last 4 digits of the credit card
   * @param {String} args.brand The credit cards brand
   */
  public function setCreditCard($company, $args)
  {
    $route = ['path' => 'subscription/company/{company}/creditcard', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);
    $requiredArguments = ['stripe_cc_source', 'last_digits', 'brand'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Set the billing address information for the given company.
   *
   * @param company
   * @param {Object} args
   * @param {String} args.company_name The companies name.
   * @param {String} args.country The companies billing address country.
   * @param {String} args.postal_code The companies billing address postal code.
   * @param {String} args.city The companies billing address city.
   * @param {String} args.street The companies billing address street.
   * @param {String} args.usident The companies "Umsatzsteuer-Identifikationsnummer". (optional)
   * @param {String} args.email The email address the invoice information gets send to. (optional)
   */
  public function setBillingAddress($company, $args)
  {
    $route = ['path' => 'subscription/company/{company}/billingaddress', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);
    $requiredArguments = ['company_name', 'country', 'postal_code', 'city', 'street'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Get the billing address information for the given company.
   *
   * @param company
   * @param {Object} args
   */
  public function getBillingAddress($company, $args)
  {
    $route = ['path' => 'subscription/company/{company}/billingaddress', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Get a list of features that are active.
   *
   * @param company
   * @param {Object} args
   */
  public function getSubscribedFeatures($company, $args)
  {
    $route = ['path' => 'subscription/company/{company}/features', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Get a list invoices.
   *
   * @param company
   * @param {Object} args
   */
  public function getCompanyInvoices($company, $args)
  {
    $route = ['path' => 'subscription/company/{company}/invoices', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * End all trials.
   *
   * @param providerIdentifier
   * @param {Object} args
   */
  public function endTrials($providerIdentifier, $args)
  {
    $route = ['path' => 'subscription/trial/{providerIdentifier}/end', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['providerIdentifier' => $providerIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

}
