<?php

namespace Leankoala\ApiClient;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Leankoala\ApiClient\Connection\Connection;
use Leankoala\ApiClient\Exception\BadRequestException;
use Leankoala\ApiClient\Exception\CompanySelectionFailedException;
use Leankoala\ApiClient\Exception\MissingArgumentException;
use Leankoala\ApiClient\Exception\NotConnectedException;
use Leankoala\ApiClient\Exception\UnknownRepositoryException;
use Leankoala\ApiClient\Repository\Repository;
use Leankoala\ApiClient\Repository\RepositoryCollection;

/**
 * Class Client.
 *
 * @author Nils Langner <nils.langner@leankoala.com>
 * created 2021-05-05
 */
class Client implements ClientInterface
{
    /**
     * The environments.
     */
    public const ENVIRONMENT_DEV = 'dev';
    public const ENVIRONMENT_LOCAL = 'local';
    public const ENVIRONMENT_STAGE = 'stage';
    public const ENVIRONMENT_PRODUCTION = 'prod';

    /**
     * The connection statuses.
     */
    public const STATUS_CONNECTED = 'connected';
    public const STATUS_DISCONNECTED = 'disconnected';

    /**
     * The standard application.
     */
    public const APPLICATION_KOALITY = 'koality';
    public const APPLICATION_LEANKOALA = 'leankoala';
    public const APPLICATION_PLESK360 = '360';

    /**
     * @var Connection|null
     */
    private $masterConnection;

    /**
     * @var Connection|null
     */
    private $clusterConnection;

    private string $environment;

    private GuzzleClientInterface $client;

    private $companies;

    /**
     * @var array
     */
    private $masterUser;

    /**
     * The possible servers.
     *
     * @var string[]
     */
    private $servers = [
        self::ENVIRONMENT_DEV => 'http://localhost:8082/',
        self::ENVIRONMENT_LOCAL => 'http://localhost/',
        self::ENVIRONMENT_STAGE => 'https://auth.stage.koalityengine.com/',
        self::ENVIRONMENT_PRODUCTION => 'https://auth.koalityengine.com/',
    ];

    /**
     * The connection status.
     *
     * @var string
     */
    private $connectionStatus = self::STATUS_DISCONNECTED;

    /**
     * @var RepositoryCollection
     */
    private $repositoryCollection;

    /**
     * Mandatory routes that are needed before the repositories are initialized.
     *
     * @var array[]
     */
    private $routes = [
        'authenticateByPassword' => [
            'version' => 1,
            'path' => '/{application}/auth/login',
            'method' => 'POST',
        ], 'authenticateByToken' => [
            'version' => 1,
            'path' => '/{application}/auth/login/token',
            'method' => 'POST',
        ],
        'authenticateAtCluster' => [
            'version' => 1,
            'path' => '/auth/tokens/token/{masterUserId}',
            'method' => 'POST',
        ],
    ];

    private $clusterUser;

    private string $application;

    /**
     * @see Connection::setSendAccessTokenInBody()
     */
    private bool $sendAccessTokenInBody = true;

    public function __construct(string $environment, ?GuzzleClientInterface $client = null, string $application = self::APPLICATION_KOALITY)
    {
        if (is_null($client)) {
            $client = new GuzzleClient();
        }

        if (!array_key_exists($environment, $this->servers)) {
            throw new \RuntimeException('Unknown environment "' . $environment . '". Allowed environments are: ' . implode(', ', array_keys($this->servers)) . '.');
        }

        $this->environment = $environment;
        $this->client = $client;
        $this->application = $application;
    }

    /**
     * Connect to the API server and retrieve the JWT for later requests.
     *
     * @param string $username          the user name for the user that should be logged in
     * @param string $password          the password for the given user
     * @param bool   $autoSelectCompany
     *
     * @throws \Exception
     * @throws GuzzleException
     */
    public function connect($username, $password, $autoSelectCompany = false)
    {
        $this->initConnection($username, $password);

        $this->repositoryCollection = new RepositoryCollection($this->masterConnection);

        if ($autoSelectCompany) {
            $this->autoSelectCompany();
        }
    }

    /**
     * Define whether the access token is also sent as "access_token" in the request body.
     *
     * The token is always sent in the Authorization header. The body copy is enabled by
     * default for backwards compatibility. The setting applies to the master and the cluster
     * connection, including connections that already exist, and to the cluster login in
     * switchCluster(), which then sends the master token in the Authorization header.
     *
     * Request data passed explicitly to a repository call is sent unchanged.
     */
    public function setSendAccessTokenInBody(bool $sendAccessTokenInBody): void
    {
        $this->sendAccessTokenInBody = $sendAccessTokenInBody;

        $this->masterConnection?->setSendAccessTokenInBody($sendAccessTokenInBody);
        $this->clusterConnection?->setSendAccessTokenInBody($sendAccessTokenInBody);
    }

    public function getClusterConnection(): Connection
    {
        return $this->clusterConnection;
    }

    public function connectByToken($user, $token)
    {
        $this->masterUser = $user;

        $this->masterConnection = $this->createConnection();

        $this->masterConnection->setAccessToken($token);
        $this->masterConnection->setApiServer($this->servers[$this->environment]);

        $this->repositoryCollection = new RepositoryCollection($this->masterConnection);

        $this->connectionStatus = self::STATUS_CONNECTED;
    }

    /**
     * @throws CompanySelectionFailedException
     */
    private function autoSelectCompany()
    {
        if (count($this->companies) === 0) {
            throw new CompanySelectionFailedException('The user is not connected to a company yet');
        }

        $company = $this->companies[0];
        $this->switchCompany($company['id']);
    }

    /**
     * @throws CompanySelectionFailedException
     */
    public function switchCompany($companyId)
    {
        foreach ($this->companies as $company) {
            if ($company['id'] === $companyId) {
                $cluster = $company['cluster'];
                $this->switchCluster($cluster);

                return true;
            }
        }

        throw new CompanySelectionFailedException('No company with ID ' . $companyId . 'found.');
    }

    /**
     * Switch the cluster.
     *
     * @param array $cluster
     * @param bool  $connect
     *
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws MissingArgumentException
     */
    public function switchCluster($cluster, $connect = true)
    {
        $this->clusterConnection = $this->createConnection();
        $this->clusterConnection->setApiServer($cluster['apiEndpoint']);

        if ($connect) {
            $tokens = $this->authenticateAtCluster();
            $this->clusterUser = $tokens['user'];
            $this->clusterConnection->setAccessToken($tokens['token']);
        }

        $this->repositoryCollection->setClusterConnection($this->clusterConnection);
    }

    /**
     * Exchange the master token for a cluster token.
     *
     * By default the master token is sent as "access_token" in the request body. If the body
     * copy is disabled, it is sent in the Authorization header instead, so the token does not
     * end up in the request body (or in BadRequestException::getData() on failure).
     *
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws MissingArgumentException
     */
    private function authenticateAtCluster(): array
    {
        $masterToken = $this->masterConnection->getAccessToken();
        $route = $this->routes['authenticateAtCluster'];

        if ($this->clusterConnection->isSendingAccessTokenInBody()) {
            return $this->clusterConnection->send($route, [
                'access_token' => $masterToken,
                'masterUserId' => $this->getMasterUser()['id'],
            ]);
        }

        // The cluster connection has no token of its own yet. Borrow the master token for this
        // single request so it is sent in the Authorization header, and never leave it behind.
        $this->clusterConnection->setAccessToken($masterToken);

        try {
            return $this->clusterConnection->send($route, [
                'masterUserId' => $this->getMasterUser()['id'],
            ]);
        } finally {
            $this->clusterConnection->setAccessToken('');
        }
    }

    /**
     * Use the given connection as cluster connection.
     *
     * If the body copy of the access token is disabled on this client, it is disabled on the
     * injected connection too. The opposite direction is not applied: a connection that was
     * configured to send the token only in the header keeps doing so.
     */
    public function setClusterConnection(Connection $clusterConnection): void
    {
        if (!$this->sendAccessTokenInBody) {
            $clusterConnection->setSendAccessTokenInBody(false);
        }

        $this->connectionStatus = self::STATUS_CONNECTED;
        $this->clusterConnection = $clusterConnection;
    }

    /**
     * @return array
     */
    public function getMasterUser()
    {
        return $this->masterUser;
    }

    /**
     * Return the master connection.
     *
     * @return Connection
     */
    public function getMasterConnections()
    {
        return $this->masterConnection;
    }

    public function setMasterUser($masterUser)
    {
        $this->masterUser = $masterUser;
    }

    public function getClusterUser()
    {
        return $this->clusterUser;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @throws BadRequestException
     * @throws MissingArgumentException
     * @throws GuzzleException
     */
    private function initConnection($username = null, $password = null, $token = null)
    {
        $this->masterConnection = $this->createConnection(['application' => $this->application]);

        $this->masterConnection->setApiServer($this->servers[$this->environment]);

        if ($username !== null && $username !== '') {
            $route = $this->routes['authenticateByPassword'];
        } elseif ($token) {
            $route = $this->routes['authenticateByToken'];
        } else {
            throw new \BadMethodCallException('Nether user name nor token is set. At least one of them is mandatory.');
        }

        $result = $this->masterConnection->send(
            $route,
            [
                'emailOrUserName' => $username,
                'password' => $password,
                'withMemories' => true,
                'token' => $token,
            ]
        );

        $accessToken = $result['token'];

        $this->masterUser = $result['user'];
        $this->companies = $result['companies'];

        $this->masterConnection->setAccessToken($accessToken);

        $this->connectionStatus = self::STATUS_CONNECTED;
    }

    private function createConnection(array $defaultParameters = []): Connection
    {
        $connection = new Connection($this->client, $defaultParameters);
        $connection->setSendAccessTokenInBody($this->sendAccessTokenInBody);

        return $connection;
    }

    /**
     * Return the repository by the given name.
     *
     * Throws an exception if the repository is not known.
     *
     * @param string $entityType
     *
     * @throws NotConnectedException
     * @throws UnknownRepositoryException
     *
     * @return Repository
     */
    public function getRepository($entityType)
    {
        if ($this->connectionStatus === self::STATUS_DISCONNECTED) {
            throw new NotConnectedException('Please connect the client before running this method.');
        }

        return $this->repositoryCollection->getRepository($entityType);
    }
}
