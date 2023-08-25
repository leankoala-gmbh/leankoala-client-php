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
class CrawlerRepository extends Repository  {

  /**
   * Run a crawl for a given checklist
   *
   * @param company
   * @param {Object} args
   * @param {Number} args.user The user (id) that starts the crawl and gets informed when the crawl
   *                            finishes
   * @param {String} args.checklist_name The check lists name (optional)
   * @param {Array} args.collections The additional collections (optional)
   * @param {String} args.name The crawls name
   * @param {Number} args.depth Number of URLs to be crawled (default: 50)
   * @param {String} args.path The URL the crawler starts to crawl
   * @param {Number} args.parallel_requests Number of parallel requests that can be done (default: 8)
   */
  public function runCompanyCrawl($company, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/crawl/company/{company}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);
    $requiredArguments = ['user', 'name', 'path'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Get all possible crawler settings. This is only needed for usability in the frontends.
   *
   * @param company
   * @param {Object} args
   */
  public function getCrawlerSettings($company, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/crawl/company/{company}/settings', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Run a crawl for a given checklist
   *
   * @param project
   * @param {Object} args
   * @param {Number} args.user The user (id) that starts the crawl and gets informed when the crawl
   *                            finishes
   * @param {String} args.checklist_name The check lists name (optional)
   * @param {Array} args.collections The additional collections (optional)
   * @param {String} args.name The crawls name
   * @param {Number} args.system The systems id
   * @param {Number} args.depth Number of URLs to be crawled (default: 5)
   * @param {String} args.path The URL the crawler starts to crawl (default: /)
   * @param {Number} args.parallel_requests Number of parallel requests that can be done (default: 8)
   */
  public function runCrawl($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/crawl/{project}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['user', 'name', 'system'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Get all collections that can be crawled.
   * @param {Object} args
   */
  public function getCrawlableCollections(array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/collections', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Abort a running crawl. The effect can take up to 5 minutes.
   *
   * @param project
   * @param crawl
   * @param {Object} args
   */
  public function abortCrawl($project, $crawl, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/crawl/{project}/{crawl}', 'method' => 'PUT', 'version' =>  1];
    $argList = array_merge(['project' => $project, 'crawl' => $crawl], $args);

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
  public function listCrawls($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/crawl/{project}/crawls', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);
    $requiredArguments = ['system'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all crawl of the given company
   *
   * @param company
   * @param {Object} args
   * @param {Number} args.pagination_start  (optional)
   * @param {Number} args.pagination_size  (default: 25)
   * @param {Boolean} args.include_collections  (default: false)
   * @param {Number} args.crawl_schedule Only show results for given crawl schedule (optional)
   */
  public function listCompanyCrawls($company, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/crawl/company/{company}/crawls', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the detailed information for a given crawl with all results (as CSV).
   *
   * @param crawl
   * @param downloadSecret
   * @param {Object} args
   */
  public function getCrawlCsv($crawl, $downloadSecret, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/crawl/detail/csv/{crawl}/{downloadSecret}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['crawl' => $crawl, 'downloadSecret' => $downloadSecret], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the detailed information for a given crawl with all results.
   *
   * @param crawl
   * @param {Object} args
   */
  public function getCrawl($crawl, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/crawl/detail/{crawl}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['crawl' => $crawl], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the crawler status for a given project.
   *
   * @param project
   * @param {Object} args
   */
  public function getCrawlerStatus($project, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/status/{project}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['project' => $project], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return the crawler status for a given company.
   *
   * @param company
   * @param {Object} args
   */
  public function getCompanyCrawlerStatus($company, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/status/company/{company}', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Set check status for a single url
   *
   * @param company
   * @param {Object} args
   * @param {*} args.check_type The check type (DeadLink)
   * @param {*} args.check_status The status that should be set
   * @param {String} args.url The url that status is valid for
   *
   * @return {setCheckStatusResult}
   */
  public function setCheckStatus($company, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/company/{company}/check/status', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);
    $requiredArguments = ['check_type', 'check_status', 'url'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Delete check status by id
   *
   * @param company
   * @param crawlUrlStatus
   * @param {Object} args
   */
  public function deleteCheckStatus($company, $crawlUrlStatus, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/company/{company}/check/status/{crawlUrlStatus}', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge(['company' => $company, 'crawlUrlStatus' => $crawlUrlStatus], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * List check status by company
   *
   * @param company
   * @param {Object} args
   */
  public function listCheckStatus($company, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/company/{company}/check/status', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * List scheduled crawls by company
   *
   * @param company
   * @param {Object} args
   */
  public function listCrawlSchedules($company, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/company/{company}/schedules', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Show scheduled crawl by id
   *
   * @param company
   * @param crawlSchedule
   * @param {Object} args
   */
  public function showCrawlSchedule($company, $crawlSchedule, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/company/{company}/schedules/{crawlSchedule}', 'method' => 'GET', 'version' =>  1];
    $argList = array_merge(['company' => $company, 'crawlSchedule' => $crawlSchedule], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Create a crawl schedule
   *
   * @param company
   * @param {Object} args
   * @param {String} args.path The URL the crawler starts to crawl
   * @param {Number} args.depth Number of URLs to be crawled (default: 50)
   * @param {Number} args.parallel_requests Number of parallel requests that can be done (default: 8)
   * @param {*} args.interval Interval at which a crawl is started
   * @param {*} args.timeslot Time window in which a crawl is started
   * @param {Number} args.day_of_month_or_week Day of month or week on which a crawl is started if
   *                                            interval is weekly or monthly (optional)
   * @param {Array} args.collections The additional collections
   * @param {String} args.timezone The time zone for which the timeslot applies
   */
  public function createCrawlSchedule($company, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/company/{company}/schedules', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company], $args);
    $requiredArguments = ['path', 'interval', 'timeslot', 'collections', 'timezone'];
    $this->assertValidArguments($requiredArguments, $argList);

    return $this->connection->send($route, $argList);
  }

  /**
   * Update a crawl schedule by id
   *
   * @param company
   * @param crawlSchedule
   * @param {Object} args
   * @param {String} args.path The URL the crawler starts to crawl (optional)
   * @param {Number} args.depth Number of URLs to be crawled (default: 50)
   * @param {Number} args.parallel_requests Number of parallel requests that can be done (default: 8)
   * @param {*} args.interval Interval at which a crawl is started (optional)
   * @param {*} args.timeslot Time window in which a crawl is started (optional)
   * @param {Number} args.day_of_month_or_week Day of month or week on which a crawl is started if
   *                                            interval is weekly or monthly (optional)
   * @param {Array} args.collections The additional collections (optional)
   * @param {Boolean} args.enabled Enable or disable the schedule (optional)
   * @param {String} args.timezone The time zone for which the timeslot applies (optional)
   */
  public function updateCrawlSchedule($company, $crawlSchedule, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/company/{company}/schedules/{crawlSchedule}', 'method' => 'PATCH', 'version' =>  1];
    $argList = array_merge(['company' => $company, 'crawlSchedule' => $crawlSchedule], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Delete crawl schedule by id
   *
   * @param company
   * @param crawlSchedule
   * @param {Object} args
   */
  public function deleteCrawlSchedule($company, $crawlSchedule, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/company/{company}/schedules/{crawlSchedule}', 'method' => 'DELETE', 'version' =>  1];
    $argList = array_merge(['company' => $company, 'crawlSchedule' => $crawlSchedule], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Run a scheduled crawl immediately
   *
   * @param company
   * @param crawlSchedule
   * @param {Object} args
   */
  public function runScheduledCrawl($company, $crawlSchedule, array $args = [])
  {
    $route = ['path' => '/kapi/v1/crawler/company/{company}/schedules/{crawlSchedule}/crawl', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge(['company' => $company, 'crawlSchedule' => $crawlSchedule], $args);

    return $this->connection->send($route, $argList);
  }

}
