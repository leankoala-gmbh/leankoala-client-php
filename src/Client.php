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
    const ENVIRONMENT_CUSTOM = 'custom';
    const ENVIRONMENT_PRODUCTION = 'production';
    const ENVIRONMENT_STAGE = 'stage';
    const ENVIRONMENT_DEVELOPMENT = 'develop';

    private $registeredRepositories = [];

    /**
     * The open connection to the Leankoala API server.
     *
     * @var Connection
     */
    private $connection;

    /**
     * Client constructor.
     *
     * @param Connection $connection
     */
    private function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return the corresponding repository for handling different aspects.
     *
     * @param string $repositoryName
     * @return Repository
     */
    public function getRepository($repositoryName)
    {
        if (array_key_exists($repositoryName, $this->registeredRepositories)) {
            $className = $this->registeredRepositories[$repositoryName];
        } else {
            $interfaceReflection = new \ReflectionClass(Repository::class);
            $className = $interfaceReflection->getNamespaceName() . '\\' . $repositoryName . 'Repository';
        }

        if (!class_exists($className)) {
            // @todo get a list of all possible repositories
            throw new \RuntimeException('No repository found with name "' . $className . '". Did you forget to register it using the registerRepositoryByClass() method?');
        }

        /** @var Repository $repository */
        $repository = new $className($this->connection);

        if (!$repository instanceof Repository) {
            throw new \RuntimeException('The class with name "' . $className . '" does not implement the Repository interface.');
        }

        return $repository;
    }

    /**
     * Every user can register own repository classes to the client.
     *
     * This can be used to create easy to use wrapper that feel like native Leankoala API
     * calls.
     *
     * @param string $name
     * @param string $className
     */
    public function registerRepositoryByClass($name, $className)
    {
        $this->registeredRepositories[$name] = $className;
    }

    /**
     * Get the API server for the current environment.
     *
     * @param string $environment
     * @param string $apiServer
     *
     * @return string
     */
    static private function getApiServer($environment, $apiServer = null)
    {
        switch ($environment) {
            case self::ENVIRONMENT_CUSTOM:
                if ($apiServer) {
                    return $apiServer;
                } else {
                    throw new \RuntimeException('If the environment is set to custom the apiSever parameter must be set.');
                }
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
     * @param string $username
     * @param string $password
     * @param string $environment
     * @param static $apiServer
     *
     * @return Client
     *
     * @throws Client\ApiError
     */
    static public function createByCredentials($username, $password, $environment = self::ENVIRONMENT_PRODUCTION, $apiServer = null)
    {
        $connection = new Connection(new GuzzleClient(), self::getApiServer($environment, $apiServer), $username, $password);
        return new self($connection);
    }

    /**
     * @param string $token
     * @param string $environment
     * @param static $apiServer
     *
     * @return Client
     *
     * @throws Client\ApiError
     */
    static public function createByJwt($token, $environment = self::ENVIRONMENT_PRODUCTION, $apiServer = null)
    {
        if (!$token) {
            throw new \RuntimeException("The token must not be null.");
        }

        $connection = new Connection(new GuzzleClient(), self::getApiServer($environment, $apiServer), $token);
        return new self($connection);
    }
}
