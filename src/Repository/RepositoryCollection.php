<?php

namespace Leankoala\ApiClient\Repository;

use Leankoala\ApiClient\Connection\Connection;
use Leankoala\ApiClient\Exception\UnknownRepositoryException;

use Leankoala\ApiClient\Repository\Entity\Auth2ApplicationRepository;
use Leankoala\ApiClient\Repository\Entity\Auth2AuthRepository;
use Leankoala\ApiClient\Repository\Entity\Auth2CompanyRepository;
use Leankoala\ApiClient\Repository\Entity\Auth2UserRepository;

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

        $this->repositories['auth2application'] = new Auth2ApplicationRepository();
        $this->repositories['auth2auth'] = new Auth2AuthRepository();
        $this->repositories['auth2company'] = new Auth2CompanyRepository();
        $this->repositories['auth2user'] = new Auth2UserRepository();
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
