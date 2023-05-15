<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2023-05-15
 */
class SubscriptionRepository extends Repository  {

  /**
   * Get the companies subscription information.
   *
   * @param $company
   * @param array $args
   */
  public function getCompanySubscription($company, array $args = [])
  {
    $route = ['path' => 'subscription/company/{company}/', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Set the companies credit card plans.
   *
   * @param $company
   * @param array $args
   * @param Integer args.quantity The number of packets to be used
   * @param Integer args.system_size The system size id (optional)
   */
  public function setCompanyCreditCardPlans($company, array $args = [])
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
   * @param $company
   * @param array $args
   * @param Integer args.quantity The number of packets to be used
   * @param Integer args.system_size The system size id
   */
  public function setCompanyFreePlans($company, array $args = [])
  {
    $route = ['path' => 'subscription/company/{company}/plans/free', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);
    $requiredArguments = ['quantity', 'system_size'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Set the companies free plans by user.
   *
   * @param $user
   * @param array $args
   * @param Integer args.quantity The number of packets to be used
   * @param Integer args.system_size The system size id
   */
  public function setCompanyFreePlansByUser($user, array $args = [])
  {
    $route = ['path' => 'subscription/user/{user}/plans/free', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['quantity', 'system_size'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Set the companies credit card.
   *
   * @param $company
   * @param array $args
   * @param Mixed args.stripe_cc_source The stripe credit card id
   * @param String args.last_digits The last 4 digits of the credit card
   * @param String args.brand The credit cards brand
   */
  public function setCreditCard($company, array $args = [])
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
   * @param $company
   * @param array $args
   * @param String args.company_name The companies name.
   * @param String args.country The companies billing address country.
   * @param String args.postal_code The companies billing address postal code.
   * @param String args.city The companies billing address city.
   * @param String args.street The companies billing address street.
   * @param String args.usident The companies "Umsatzsteuer-Identifikationsnummer". (optional)
   * @param String args.email The email address the invoice information gets send to. (optional)
   */
  public function setBillingAddress($company, array $args = [])
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
   * @param $company
   * @param array $args
   */
  public function getBillingAddress($company, array $args = [])
  {
    $route = ['path' => 'subscription/company/{company}/billingaddress', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Get a list of features that are active.
   *
   * @param $company
   * @param array $args
   */
  public function getSubscribedFeatures($company, array $args = [])
  {
    $route = ['path' => 'subscription/company/{company}/features', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Get a list invoices for the given company.
   *
   * @param $company
   * @param array $args
   */
  public function getCompanyInvoices($company, array $args = [])
  {
    $route = ['path' => 'subscription/company/{company}/invoices', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Set the subscription plan of the given user.
   *
   * @param $user
   * @param array $args
   * @param String args.identifier 
   */
  public function setSubscriptionPlan($user, array $args = [])
  {
    $route = ['path' => 'subscription/user/{user}/plan', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['user' => $user], $args);
    $requiredArguments = ['identifier'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Get current quota for the company.
   *
   * @param $company
   * @param array $args
   */
  public function getQuota($company, array $args = [])
  {
    $route = ['path' => 'subscription/company/{company}/quota', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * End all trials.
   *
   * @param $providerIdentifier
   * @param array $args
   */
  public function endTrials($providerIdentifier, array $args = [])
  {
    $route = ['path' => 'subscription/trial/{providerIdentifier}/end', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['providerIdentifier' => $providerIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

}
