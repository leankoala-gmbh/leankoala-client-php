<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2021-10-13
 */
class ClusterRepository extends Repository implements \Leankoala\ApiClient\Repository\MasterConnectionRepository {

    /**
     * @param application
     * @param {Object} args
     * @param {String} args.identifier
     */
    public function getCluster($application, $args)
    {
        $route = ['path' => '/api/{application}/cluster', 'method' => 'GET', 'version' =>  1];
        $argList = array_merge(['application' => $application], $args);
        $requiredArguments = ['identifier'];
        $this->assertValidArguments($requiredArguments, $argList);

        return $this->connection->send($route, $argList, false);
    }

}
