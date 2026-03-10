<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2026-03-10
 */
class SubscriptionRepository extends Repository {

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
     * @param Integer args.system_size The system size id (optional)
     * @param String args.identifier  (optional)
     */
    public function setCompanyFreePlansByUser($user, array $args = [])
    {
        $route = ['path' => 'subscription/user/{user}/plans/free', 'method' => 'POST', 'version' =>  1];
        $argList = array_merge(['user' => $user], $args);
        $requiredArguments = ['quantity'];
        $this->assertValidArguments($requiredArguments, $argList);

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
     * Get current quota for the project.
     *
     * @param $project
     * @param array $args
     */
    public function getQuotaByProject($project, array $args = [])
    {
        $route = ['path' => 'subscription/project/{project}/quota', 'method' => 'GET', 'version' =>  1];
        $argList = array_merge(['project' => $project], $args);

        return $this->connection->send($route, $argList);
    }

    /**
     * Get a list of subscription products.
     * @param array $args
     */
    public function getSubscriptionProducts(array $args = [])
    {
        $route = ['path' => 'subscription/products', 'method' => 'GET', 'version' =>  1];
        $argList = array_merge([], $args);

        return $this->connection->send($route, $argList);
    }

    /**
     * Create a checkout session for current user.
     *
     * @param array $args
     * @param String args.price_id The product price id
     * @param String args.success_url
     * @param String args.cancel_url
     * @param String args.two_factor_code  (optional)
     */
    public function createCheckoutSession(array $args = [])
    {
        $route = ['path' => 'subscription/checkout/session', 'method' => 'POST', 'version' =>  1];
        $argList = array_merge([], $args);
        $requiredArguments = ['price_id', 'success_url', 'cancel_url'];
        $this->assertValidArguments($requiredArguments, $argList);

        return $this->connection->send($route, $argList);
    }

    /**
     * Create a customer portal session for current user.
     *
     * @param array $args
     * @param String args.return_url
     */
    public function createCustomerPortalSession(array $args = [])
    {
        $route = ['path' => 'subscription/portal/session', 'method' => 'POST', 'version' =>  1];
        $argList = array_merge([], $args);
        $requiredArguments = ['return_url'];
        $this->assertValidArguments($requiredArguments, $argList);

        return $this->connection->send($route, $argList);
    }

    /**
     * Cancel a subscription.
     *
     * @param $subscriptionId
     * @param array $args
     */
    public function cancelSubscription($subscriptionId, array $args = [])
    {
        $route = ['path' => 'subscription/external/{subscriptionId}', 'method' => 'DELETE', 'version' =>  1];
        $argList = array_merge(['subscriptionId' => $subscriptionId], $args);

        return $this->connection->send($route, $argList);
    }

    /**
     * Get a list of subscriptions for current user.
     * @param array $args
     */
    public function getUserSubscriptions(array $args = [])
    {
        $route = ['path' => 'subscription', 'method' => 'GET', 'version' =>  1];
        $argList = array_merge([], $args);

        return $this->connection->send($route, $argList);
    }

    /**
     * Update subscription by project.
     *
     * @param $project
     * @param array $args
     * @param String args.price_id The product price id
     * @param String args.success_url
     * @param String args.cancel_url
     * @param String args.two_factor_code  (optional)
     */
    public function updateSubscriptionByProject($project, array $args = [])
    {
        $route = ['path' => 'subscription/project/{project}', 'method' => 'POST', 'version' =>  1];
        $argList = array_merge(['project' => $project], $args);
        $requiredArguments = ['price_id', 'success_url', 'cancel_url'];
        $this->assertValidArguments($requiredArguments, $argList);

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
