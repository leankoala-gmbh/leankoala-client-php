<?php

namespace Leankoala\ApiClient;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Leankoala\ApiClient\Connection\Connection;
use Leankoala\ApiClient\Exception\BadRequestException;
use Leankoala\ApiClient\Exception\MissingArgumentException;
use Leankoala\ApiClient\Exception\NotConnectedException;
use Leankoala\ApiClient\Exception\UnknownRepositoryException;
use Leankoala\ApiClient\Repository\Repository;
use Leankoala\ApiClient\Repository\RepositoryCollection;

/**
 * Class Client
 *
 * @package Leankoala\ApiClient
 *
 * @author Nils Langner <nils.langner@leankoala.com>
 * created 2021-05-05
 */
class Client
{
    /**
     * The environments
     */
    const ENVIRONMENT_DEVELOP = 'dev';
    const ENVIRONMENT_STAGE = 'stage';
    const ENVIRONMENT_PRODUCTION = 'prod';

    /**
     * The connection statuses
     */
    const STATUS_CONNECTED = 'connected';
    const STATUS_DISCONNECTED = 'disconnected';

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var GuzzleClient
     */
    private $client;

    /**
     * The possible servers.
     *
     * @var string[]
     */
    private $servers = [
        self::ENVIRONMENT_DEVELOP => 'http://localhost:8082/',
        self::ENVIRONMENT_STAGE => 'https://stage.monitor.leankoala.com/kapi/',
        self::ENVIRONMENT_PRODUCTION => 'https://api.cluster1.koalityengine.com/'
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
     * Client constructor.
     *
     * @param string $environment
     * @param GuzzleClient|null $client
     */
    public function __construct($environment, $client = null)
    {
        if (is_null($client)) {
            $client = new GuzzleClient();
        }

        if (!array_key_exists($environment, $this->servers)) {
            throw new \RuntimeException('Unknown environment "' . $environment . '". Allowed environments are: ' . implode(', ', array_keys($this->servers)) . '.');
        }

        $this->environment = $environment;
        $this->client = $client;
    }

    /**
     * Connect to the API server and retrieve the JWT for later requests.
     *
     * @param {Object} args
     * @param {String} [args.username] the user name for the user that should be logged in
     * @param {String} [args.password the password for the given user
     * @param {String} [args.wakeUpToken] the wakeup token can be used to log in instead of username and pasword
     * @param {Boolean} [args.withMemories] return the users memory on connect
     * @param {String} [args.language] the preferred language (default: en; implemented: de, en)
     * @param {Object} [args.axiosAdapter] the preferred language (default: en; implemented: de, en)
     * @param {function} [args.axios] a predefined axios instance
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function connect($username, $password)
    {
        try {
            $this->initConnection($username, $password);
        } catch (Exception $exception) {
            throw $exception;
        }

        $this->repositoryCollection = new RepositoryCollection($this->connection);
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @throws BadRequestException
     * @throws MissingArgumentException
     * @throws GuzzleException
     */
    private function initConnection($username, $password)
    {
        $this->connection = new Connection($this->servers[$this->environment], $this->client);
        $this->connection->connect($username, $password, []);

        $this->connectionStatus = self::STATUS_CONNECTED;
    }

    /**
     * Return the repository by the given name.
     *
     * Throws an exception if the repository is not known.
     *
     * @param string entityType
     *
     * @return Repository
     *
     * @throws NotConnectedException
     * @throws UnknownRepositoryException
     */
    public function getRepository($entityType)
    {
        if ($this->connectionStatus === self::STATUS_DISCONNECTED) {
            throw new NotConnectedException('Please connect the client before running this method.');
        }

        return $this->repositoryCollection->getRepository($entityType);
    }
}
