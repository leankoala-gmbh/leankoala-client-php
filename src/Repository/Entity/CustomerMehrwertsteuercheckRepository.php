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
class CustomerMehrwertsteuercheckRepository extends Repository  {

  /**
   * Mehrwertsteuer Check only: Start a new crawl for the given start page. Max. 100 urls are crawled
   * with 4 parallel requests.
   *
   * @param {Object} args
   * @param {String} args.email_address The email address the crawl result is send to.
   * @param {Url} args.start_url The url the crawler should start with.
   */
  public function runMwstCrawl($args)
  {
    $route = ['path' => 'customers/mehrwertsteuer/crawl', 'method' => 'POST', 'version' =>  1];
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
  public function showCrawlResult($crawlIdentifier, $args)
  {
    $route = ['path' => 'customers/mehrwertsteuer/crawl/{crawlIdentifier}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['crawlIdentifier' => $crawlIdentifier], $args);

    return $this->connection->send($route, $argList);
  }

}
