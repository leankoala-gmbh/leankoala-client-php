<?php

namespace Leankoala\ApiClient\Repository;

use Leankoala\ApiClient\Connection\Connection;
use Leankoala\ApiClient\Exception\NotConnectedException;
use Leankoala\ApiClient\Exception\UnknownRepositoryException;
use Leankoala\ApiClient\Repository\Entity\AlertingChannelRepository;
use Leankoala\ApiClient\Repository\Entity\AlertingPolicyRepository;
use Leankoala\ApiClient\Repository\Entity\ApplicationRepository;
use Leankoala\ApiClient\Repository\Entity\Auth2Repository;
use Leankoala\ApiClient\Repository\Entity\AuthRepository;
use Leankoala\ApiClient\Repository\Entity\CheckA11yRepository;
use Leankoala\ApiClient\Repository\Entity\CheckBrokenResourceRepository;
use Leankoala\ApiClient\Repository\Entity\CheckCertificateRepository;
use Leankoala\ApiClient\Repository\Entity\CheckCookieRepository;
use Leankoala\ApiClient\Repository\Entity\CheckDeadLinksRepository;
use Leankoala\ApiClient\Repository\Entity\CheckFileSizeRepository;
use Leankoala\ApiClient\Repository\Entity\CheckHealthCheckRepository;
use Leankoala\ApiClient\Repository\Entity\CheckInsecureContentRepository;
use Leankoala\ApiClient\Repository\Entity\CheckJavaScriptErrorsRepository;
use Leankoala\ApiClient\Repository\Entity\CheckLighthouseRepository;
use Leankoala\ApiClient\Repository\Entity\CheckMobileFriendlyRepository;
use Leankoala\ApiClient\Repository\Entity\CheckRepository;
use Leankoala\ApiClient\Repository\Entity\CheckSitemapRepository;
use Leankoala\ApiClient\Repository\Entity\CompanyRepository;
use Leankoala\ApiClient\Repository\Entity\ComponentRepository;
use Leankoala\ApiClient\Repository\Entity\CrawlerRepository;
use Leankoala\ApiClient\Repository\Entity\CustomerHaendlerbundMetricRepository;
use Leankoala\ApiClient\Repository\Entity\CustomerHaendlerbundRepository;
use Leankoala\ApiClient\Repository\Entity\CustomerMehrwertsteuercheckRepository;
use Leankoala\ApiClient\Repository\Entity\IncidentRepository;
use Leankoala\ApiClient\Repository\Entity\InvitationRepository;
use Leankoala\ApiClient\Repository\Entity\MarketplaceRepository;
use Leankoala\ApiClient\Repository\Entity\MemoryRepository;
use Leankoala\ApiClient\Repository\Entity\MetricRepository;
use Leankoala\ApiClient\Repository\Entity\ProjectRepository;
use Leankoala\ApiClient\Repository\Entity\ScoreRepository;
use Leankoala\ApiClient\Repository\Entity\ScreenshotRepository;
use Leankoala\ApiClient\Repository\Entity\SubscriptionRepository;
use Leankoala\ApiClient\Repository\Entity\SystemRepository;
use Leankoala\ApiClient\Repository\Entity\ToolRepository;
use Leankoala\ApiClient\Repository\Entity\UserRepository;
use Leankoala\ApiClient\Repository\Entity\WebsocketRepository;

/**
 * Class RepositoryCollection
 *
 * @package Leankoala\ApiClient\Repository
 *
 * @author Nils Langner <nils.langner@leankoala.com>
 * @author Sascha Fuchs <sascha.fuchs@leankoala.com>
 *
 * created 2021-05-06
 */
class RepositoryCollection
{
    /**
     * @var Repository[]
     */
    private $repositories = [];

    /**
     * @var Connection
     */
    private $masterConnection;

    /**
     * @var Connection
     */
    private $clusterConnection;

    /**
     * RepositoryCollection constructor.
     *
     * @param Connection $masterConnection
     */
    public function __construct($masterConnection)
    {
        $this->masterConnection = $masterConnection;

        $this->repositories['application'] = new ApplicationRepository();
        $this->repositories['auth2'] = new Auth2Repository();
        $this->repositories['company'] = new CompanyRepository();
        $this->repositories['user'] = new UserRepository();

        $this->repositories['marketplace'] = new MarketplaceRepository();
        $this->repositories['subscription'] = new SubscriptionRepository();
        $this->repositories['crawler'] = new CrawlerRepository();
        $this->repositories['customerhaendlerbund'] = new CustomerHaendlerbundRepository();
        $this->repositories['customerhaendlerbundmetric'] = new CustomerHaendlerbundMetricRepository();
        $this->repositories['customermehrwertsteuercheck'] = new CustomerMehrwertsteuercheckRepository();
        $this->repositories['memory'] = new MemoryRepository();
        $this->repositories['score'] = new ScoreRepository();
        $this->repositories['alertingpolicy'] = new AlertingPolicyRepository();
        $this->repositories['alertingchannel'] = new AlertingChannelRepository();
        $this->repositories['websocket'] = new WebsocketRepository();
        $this->repositories['metric'] = new MetricRepository();
        $this->repositories['auth'] = new AuthRepository();
        $this->repositories['invitation'] = new InvitationRepository();
        $this->repositories['component'] = new ComponentRepository();
        $this->repositories['project'] = new ProjectRepository();
        $this->repositories['system'] = new SystemRepository();
        $this->repositories['screenshot'] = new ScreenshotRepository();
        $this->repositories['tool'] = new ToolRepository();
        $this->repositories['check'] = new CheckRepository();
        $this->repositories['checklighthouse'] = new CheckLighthouseRepository();
        $this->repositories['checka11y'] = new CheckA11yRepository();
        $this->repositories['checkbrokenresource'] = new CheckBrokenResourceRepository();
        $this->repositories['checkjavascripterrors'] = new CheckJavaScriptErrorsRepository();
        $this->repositories['checkfilesize'] = new CheckFileSizeRepository();
        $this->repositories['checksitemap'] = new CheckSitemapRepository();
        $this->repositories['checkmobilefriendly'] = new CheckMobileFriendlyRepository();
        $this->repositories['checkcertificate'] = new CheckCertificateRepository();
        $this->repositories['checkinsecurecontent'] = new CheckInsecureContentRepository();
        $this->repositories['checkcookie'] = new CheckCookieRepository();
        $this->repositories['checkdeadlinks'] = new CheckDeadLinksRepository();
        $this->repositories['checkhealthcheck'] = new CheckHealthCheckRepository();
        $this->repositories['incident'] = new IncidentRepository();
    }

    /**
     * Set the connection for the currently used cluster.
     *
     * @param Connection $connection
     */
    public function setClusterConnection(Connection $connection)
    {
        $this->clusterConnection = $connection;
    }

    /**
     * Get the initialized repository that is already connected.
     *
     * @param string $entityType
     * @return Repository
     *
     * @throws UnknownRepositoryException
     * @throws NotConnectedException
     */
    public function getRepository($entityType)
    {
        $repositoryName = strtolower($entityType);

        if (!array_key_exists($repositoryName, $this->repositories)) {
            throw new UnknownRepositoryException('No repository with name ' . $repositoryName . ' found. Registered repositories are: ' . implode(', ', array_keys($this->repositories)) . '.');
        }

        $repo = $this->repositories[$entityType];

        if ($repo instanceof MasterConnectionRepository) {
            $repo->init($this->masterConnection);
        } else {
            if (is_null($this->clusterConnection)) {
                throw new NotConnectedException('No connection established to the cluster. This will be triggert by the company selection.');
            }
            $repo->init($this->clusterConnection);
        }

        return $repo;
    }
}
