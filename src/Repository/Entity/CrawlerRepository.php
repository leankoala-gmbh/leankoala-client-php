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
class CrawlerRepository extends Repository  {

  /**
   * Run a crawl for a given checklist
   *
   * @param project
   * @param {Object} args
   * @param {Number} args.user The user (id) that starts the crawl and gets informed when the crawl
   *                            finishes
   * @param {String} args.checklist_name The check lists name
   * @param {String} args.name The crawls name
   * @param {Number} args.system The systems id
   * @param {Number} args.depth Number of URLs to be crawled (default: 5)
   * @param {String} args.path The URL the crawler starts to crawl (default: /)
   * @param {Number} args.parallel_requests Number of parallel requests that can be done (default: 8)
   */
  public function runCrawl($project, $args)
  {
    $route = ['path' => 'crawler/crawl/{project}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['user', 'checklist_name', 'name', 'system'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all crawl by the given parameters
   *
   * @param project
   * @param {Object} args
   * @param {String} args.checklist_name The check lists name (optional)
   * @param {Number} args.system The systems id
   */
  public function listCrawls($project, $args)
  {
    $route = ['path' => 'crawler/crawl/{project}/crawls', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['system'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Abort a running crawl. The effect can take up to 5 minutes.
   *
   * @param project
   * @param crawl
   * @param {Object} args
   */
  public function abortCrawl($project, $crawl, $args)
  {
    $route = ['path' => 'crawler/crawl/{project}/{crawl}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'crawl' => $crawl], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the detailed information for a given crawl with all results.
   *
   * @param crawl
   * @param {Object} args
   */
  public function getCrawl($crawl, $args)
  {
    $route = ['path' => 'crawler/crawl/{crawl}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['crawl' => $crawl], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the crawler status for a given project.
   *
   * @param project
   * @param {Object} args
   */
  public function getCrawlerStatus($project, $args)
  {
    $route = ['path' => 'crawler/status/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

}
