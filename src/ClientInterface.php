<?php

namespace Leankoala\ApiClient;

use Leankoala\ApiClient\Exception\NotConnectedException;
use Leankoala\ApiClient\Exception\UnknownRepositoryException;
use Leankoala\ApiClient\Repository\Repository;

/**
 * Interface ClientInterface
 *
 * @package Leankoala\ApiClient
 *
 * @author Nils Langner <nils.langner@leankoala.com>
 * created 2021-10-25
 */
interface ClientInterface
{
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
    public function getRepository($entityType);
}
