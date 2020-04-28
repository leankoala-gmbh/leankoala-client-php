<?php

namespace Leankoala\LeankoalaClient\Repository;

use Leankoala\LeankoalaClient\Client\Connection;

interface Repository
{
    public function __construct(Connection $connection);
}
