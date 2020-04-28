<?php

namespace Leankoala\LeankoalaClient;

use GuzzleHttp\Client as GuzzleClient;
use Leankoala\LeankoalaClient\Client\Connection;
use Leankoala\LeankoalaClient\Repository\Repository;

/**
 * Class Client
 *
 * @package Leankoala\LeankoalaClient
 *
 * @author Nils Langner (nils.langner@leankoala.com)
 * @created 2020-04-15
 */
class Client
{
    /** List of all api servers */
    const API_SERVER_PRODUCTION = 'https://api.leankoala.com/';
    const API_SERVER_STAGE = 'https://api.stage.monitor.leankoala.com';
    const API_SERVER_DEVELOPMENT = 'http://localhost:8081/kapi/';

    /** List of all environments */
    const ENVIRONMENT_PRODUCTION = 'production';
    const ENVIRONMENT_STAGE = 'stage';
    const ENVIRONMENT_DEVELOPMENT = 'develop';

    /**
     * List of allowed environments.
     * Stage and development environment is only used by the Leankoala team.
     *
     * @var string[]
     */
    private $allowedEnvironments = [
        self::ENVIRONMENT_PRODUCTION,
        self::ENVIRONMENT_STAGE,
        self::ENVIRONMENT_DEVELOPMENT
    ];

    /**
     * The current environment.
     *
     * @var string
     */
    private $environment;

    /**
     * The open connection to the Leankoala API server.
     *
     * @var Connection
     */
    private $connection;

    /**
     * Client constructor.
     *
     * @param string $username
     * @param string $password
     * @param string $environment
     */
    public function __construct($username, $password, $environment = self::ENVIRONMENT_PRODUCTION)
    {
        $this->assertValidEnvironment($environment);
        $this->environment = $environment;

        $httpClient = new GuzzleClient();

        $this->connection = new Connection($httpClient, $this->getApiServer(), $username, $password);
    }

    /**
     * Return the corresponding repository for handling different aspects.
     *
     * @param string $repositoryName
     * @return Repository
     */
    public function getRepository($repositoryName)
    {
        $interfaceReflection = new \ReflectionClass(Repository::class);
        $className = $interfaceReflection->getNamespaceName() . '\\' . $repositoryName . 'Repository';

        if (!class_exists($className)) {
            // @todo get a list of all possible repositories
            throw new \RuntimeException('No repository found with name "' . $className . '".');
        }

        /** @var Repository $repository */
        $repository = new $className($this->connection);

        return $repository;
    }

    /**
     * Get the API server for the current environment.
     *
     * @return string
     */
    private function getApiServer()
    {
        switch ($this->environment) {
            case self::ENVIRONMENT_PRODUCTION:
                return self::API_SERVER_PRODUCTION;
            case self::ENVIRONMENT_STAGE:
                return self::API_SERVER_STAGE;
            case self::ENVIRONMENT_DEVELOPMENT:
                return self::API_SERVER_DEVELOPMENT;
            default:
                throw new \RuntimeException('No API server for this environment found.');
        }
    }

    /**
     * Throws an exception if the given environment is not valid.
     *
     * @param string $environment
     * @throws \RuntimeException
     */
    private function assertValidEnvironment($environment)
    {
        if (!in_array($environment, $this->allowedEnvironments)) {
            throw new \RuntimeException('The given environment is not allowed. Allowed values are ' . implode(', ', $this->allowedEnvironments) . '.');
        }
    }
}
