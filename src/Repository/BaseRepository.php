<?php

namespace Leankoala\LeankoalaClient\Repository;

use Leankoala\LeankoalaClient\Client\Connection;

abstract class BaseRepository implements Repository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return the connection object for communication with the Leankoala
     * server.
     *
     * @return Connection
     */
    protected function getConnection()
    {
        return $this->connection;
    }
}

