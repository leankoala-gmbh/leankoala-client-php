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
class CustomerMehrwertsteuercheckRepository extends Repository  {

  /**
   * Mehrwertsteuer Check only: Start a new crawl for the given start page. Max. 100 urls are crawled
   * with 4 parallel requests.
   *
   * @param {Object} args
   * @param {String} args.email_address The email address the crawl result is send to.
   * @param {Url} args.start_url The url the crawler should start with.
   */
  public function runMwstCrawl(array $args = [])
  {
    $route = ['path' => '/kapi/v1/customers/mehrwertsteuer/crawl', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);
    $requiredArguments = ['email_address', 'start_url'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Mehrwertsteuer Check only: get the status and check result of the crawl with the given unique
   * identifier
   *
   * @param crawlIdentifier
   * @param {Object} args
   */
  public function showCrawlResult($crawlIdentifier, array $args = [])
  {
    $route = ['path' => '/kapi/v1/customers/mehrwertsteuer/crawl/{crawlIdentifier}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['crawlIdentifier' => $crawlIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

}
