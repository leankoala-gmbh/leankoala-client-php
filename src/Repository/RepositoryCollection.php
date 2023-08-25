<?php

namespace Leankoala\ApiClient\Repository;

use Leankoala\ApiClient\Connection\Connection;
use Leankoala\ApiClient\Exception\UnknownRepositoryException;

use Leankoala\ApiClient\Repository\Entity\AlertingChannelRepository;
use Leankoala\ApiClient\Repository\Entity\AlertingPolicyRepository;
use Leankoala\ApiClient\Repository\Entity\AuthRepository;
use Leankoala\ApiClient\Repository\Entity\CheckRepository;
use Leankoala\ApiClient\Repository\Entity\NixstatsRepository;
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
use Leankoala\ApiClient\Repository\Entity\CheckSitemapRepository;
use Leankoala\ApiClient\Repository\Entity\ToolRepository;
use Leankoala\ApiClient\Repository\Entity\CrawlerRepository;
use Leankoala\ApiClient\Repository\Entity\CustomerHaendlerbundMetricRepository;
use Leankoala\ApiClient\Repository\Entity\CustomerHaendlerbundRepository;
use Leankoala\ApiClient\Repository\Entity\CustomerMehrwertsteuercheckRepository;
use Leankoala\ApiClient\Repository\Entity\IncidentRepository;
use Leankoala\ApiClient\Repository\Entity\MarketplaceRepository;
use Leankoala\ApiClient\Repository\Entity\MemoryRepository;
use Leankoala\ApiClient\Repository\Entity\MetricRepository;
use Leankoala\ApiClient\Repository\Entity\ComponentRepository;
use Leankoala\ApiClient\Repository\Entity\LocationRepository;
use Leankoala\ApiClient\Repository\Entity\ProjectRepository;
use Leankoala\ApiClient\Repository\Entity\ScreenshotRepository;
use Leankoala\ApiClient\Repository\Entity\SystemRepository;
use Leankoala\ApiClient\Repository\Entity\ScoreRepository;
use Leankoala\ApiClient\Repository\Entity\SequenceRepository;
use Leankoala\ApiClient\Repository\Entity\SubscriptionRepository;
use Leankoala\ApiClient\Repository\Entity\ClusterCompanyRepository;
use Leankoala\ApiClient\Repository\Entity\InvitationRepository;
use Leankoala\ApiClient\Repository\Entity\UserSubscriptionRepository;
use Leankoala\ApiClient\Repository\Entity\ClusterUserRepository;
use Leankoala\ApiClient\Repository\Entity\WebsocketRepository;

/**
 * Class RepositoryCollection
 *
 * @package Leankoala\ApiClient\Repository
 *
 * @author Nils Langner <nils.langner@leankoala.com>
 * @author Sascha Fuchs <sascha.fuchs@leankoala.com>
 *
 * created 2023-08-25
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
    private $connection;

    /**
     * RepositoryCollection constructor.
     *
     * @param Connection $connection
     */
    public function __construct($connection)
    {
        $this->connection = $connection;

        $this->repositories['alertingchannel'] = new AlertingChannelRepository();
        $this->repositories['alertingpolicy'] = new AlertingPolicyRepository();
        $this->repositories['auth'] = new AuthRepository();
        $this->repositories['check'] = new CheckRepository();
        $this->repositories['nixstats'] = new NixstatsRepository();
        $this->repositories['checka11y'] = new CheckA11yRepository();
        $this->repositories['checkbrokenresource'] = new CheckBrokenResourceRepository();
        $this->repositories['checkcertificate'] = new CheckCertificateRepository();
        $this->repositories['checkcookie'] = new CheckCookieRepository();
        $this->repositories['checkdeadlinks'] = new CheckDeadLinksRepository();
        $this->repositories['checkfilesize'] = new CheckFileSizeRepository();
        $this->repositories['checkhealthcheck'] = new CheckHealthCheckRepository();
        $this->repositories['checkinsecurecontent'] = new CheckInsecureContentRepository();
        $this->repositories['checkjavascripterrors'] = new CheckJavaScriptErrorsRepository();
        $this->repositories['checklighthouse'] = new CheckLighthouseRepository();
        $this->repositories['checkmobilefriendly'] = new CheckMobileFriendlyRepository();
        $this->repositories['checksitemap'] = new CheckSitemapRepository();
        $this->repositories['tool'] = new ToolRepository();
        $this->repositories['crawler'] = new CrawlerRepository();
        $this->repositories['customerhaendlerbundmetric'] = new CustomerHaendlerbundMetricRepository();
        $this->repositories['customerhaendlerbund'] = new CustomerHaendlerbundRepository();
        $this->repositories['customermehrwertsteuercheck'] = new CustomerMehrwertsteuercheckRepository();
        $this->repositories['incident'] = new IncidentRepository();
        $this->repositories['marketplace'] = new MarketplaceRepository();
        $this->repositories['memory'] = new MemoryRepository();
        $this->repositories['metric'] = new MetricRepository();
        $this->repositories['component'] = new ComponentRepository();
        $this->repositories['location'] = new LocationRepository();
        $this->repositories['project'] = new ProjectRepository();
        $this->repositories['screenshot'] = new ScreenshotRepository();
        $this->repositories['system'] = new SystemRepository();
        $this->repositories['score'] = new ScoreRepository();
        $this->repositories['sequence'] = new SequenceRepository();
        $this->repositories['subscription'] = new SubscriptionRepository();
        $this->repositories['clustercompany'] = new ClusterCompanyRepository();
        $this->repositories['invitation'] = new InvitationRepository();
        $this->repositories['usersubscription'] = new UserSubscriptionRepository();
        $this->repositories['clusteruser'] = new ClusterUserRepository();
        $this->repositories['websocket'] = new WebsocketRepository();
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
