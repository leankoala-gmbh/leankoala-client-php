<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2021-11-21
 */
class CrawlerRepository extends Repository  {

  /**
   * Run a crawl for a given checklist
   *
   * @param $project
   * @param array $args
   * @param {Integer} args.user The user (id) that starts the crawl and gets informed when the crawl
   *                            finishes
   * @param {String} args.checklist_name The check lists name (optional)
   * @param {Array} args.collections The additional collections (optional)
   * @param {String} args.name The crawls name
   * @param {Integer} args.system The systems id
   * @param {Integer} args.depth Number of URLs to be crawled (default: 5)
   * @param {String} args.path The URL the crawler starts to crawl (default: /)
   * @param {Integer} args.parallel_requests Number of parallel requests that can be done (default: 8)
   */
  public function runCrawl($project, array $args)
  {
    $route = ['path' => 'crawler/crawl/{project}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['user', 'name', 'system'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Run a crawl for a given checklist
   *
   * @param $company
   * @param array $args
   * @param {Integer} args.user The user (id) that starts the crawl and gets informed when the crawl
   *                            finishes
   * @param {String} args.checklist_name The check lists name (optional)
   * @param {Array} args.collections The additional collections (optional)
   * @param {String} args.name The crawls name
   * @param {Integer} args.depth Number of URLs to be crawled (default: 5)
   * @param {String} args.path The URL the crawler starts to crawl (default: /)
   * @param {Integer} args.parallel_requests Number of parallel requests that can be done (default: 8)
   */
  public function runCompanyCrawl($company, array $args)
  {
    $route = ['path' => 'crawler/crawl/company/{company}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);
    $requiredArguments = ['user', 'name'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all crawl by the given parameters
   *
   * @param $project
   * @param array $args
   * @param {String} args.checklist_name The check lists name (optional)
   * @param {Integer} args.system The systems id
   */
  public function listCrawls($project, array $args)
  {
    $route = ['path' => 'crawler/crawl/{project}/crawls', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['system'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all crawl of the given company
   *
   * @param $company
   * @param array $args
   */
  public function listCompanyCrawls($company, array $args)
  {
    $route = ['path' => 'crawler/crawl/company/{company}/crawls', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Abort a running crawl. The effect can take up to 5 minutes.
   *
   * @param $project
   * @param $crawl
   * @param array $args
   */
  public function abortCrawl($project, $crawl, array $args)
  {
    $route = ['path' => 'crawler/crawl/{project}/{crawl}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'crawl' => $crawl], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the detailed information for a given crawl with all results.
   *
   * @param $crawl
   * @param array $args
   */
  public function getCrawl($crawl, array $args)
  {
    $route = ['path' => 'crawler/crawl/{crawl}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['crawl' => $crawl], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the crawler status for a given project.
   *
   * @param $project
   * @param array $args
   */
  public function getCrawlerStatus($project, array $args)
  {
    $route = ['path' => 'crawler/status/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the crawler status for a given company.
   *
   * @param $company
   * @param array $args
   */
  public function getCompanyCrawlerStatus($company, array $args)
  {
    $route = ['path' => 'crawler/status/company/{company}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Get all collections that can be crawled.
   * @param array $args
   */
  public function getCrawlableCollections(array $args)
  {
    $route = ['path' => 'crawler/collections', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);

    return $this->connection->send($route, $argList);
  }

}
