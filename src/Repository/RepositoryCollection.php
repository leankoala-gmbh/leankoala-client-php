<?php

namespace Leankoala\ApiClient\Repository;

use Leankoala\ApiClient\Connection\Connection;
use Leankoala\ApiClient\Exception\UnknownRepositoryException;

use Leankoala\ApiClient\Repository\Entity\ApplicationRepository;
use Leankoala\ApiClient\Repository\Entity\Auth2Repository;
use Leankoala\ApiClient\Repository\Entity\CompanyRepository;
use Leankoala\ApiClient\Repository\Entity\UserRepository;

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
    private $connection;

    /**
     * RepositoryCollection constructor.
     *
     * @param Connection $connection
     */
    public function __construct($connection)
    {
        $this->connection = $connection;

        $this->repositories['application'] = new ApplicationRepository();
        $this->repositories['auth2'] = new Auth2Repository();
        $this->repositories['company'] = new CompanyRepository();
        $this->repositories['user'] = new UserRepository();
    }

    /**
     * Get the initialized repository that is already connected.
     *
     * @param string $entityType
     * @return Repository
     *
     * @throws UnknownRepositoryException
     */
    public function getRepository($entityType)
    {
        $repositoryName = strtolower($entityType);

        if (!array_key_exists($repositoryName, $this->repositories)) {
            throw new UnknownRepositoryException('No repository with name ' . $repositoryName . ' found. Registered repositories are: ' . implode(', ', array_keys($this->repositories)) . '.');
        }

        $repo = $this->repositories[$entityType];
        $repo->init($this->connection);

        return $repo;
    }
}
