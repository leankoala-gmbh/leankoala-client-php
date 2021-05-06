<?php

namespace Leankoala\ApiClient\Repository;

use Leankoala\ApiClient\Exception\MissingArgumentException;

/**
 * Class Repository
 *
 *
 * @author Nils Langner <nils.langner@leankoala.com>
 * created 2021-05-05
 */
abstract class Repository
{
    protected $connection;

    public function init($connection)
    {
        $this->connection = $connection;
    }

    /**
     * Throw an exception if a mandatory argument is not set.
     *
     * @throws MissingArgumentException
     */
    protected function assertValidArguments(array $requiredArguments, array $argList)
    {
        foreach ($requiredArguments as $requiredArgument) {
            if (!array_key_exists($requiredArgument, $argList)) {
                throw new MissingArgumentException('The argument "' . $requiredArgument . '" is missing.');
            }
        }
    }
}
