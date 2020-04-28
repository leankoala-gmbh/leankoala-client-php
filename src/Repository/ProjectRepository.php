<?php

namespace Leankoala\LeankoalaClient\Repository;

class ProjectRepository extends BaseRepository
{
    const ENDPOINT_PROJECT_CREATE = '/v1/project/projects';

    /**
     * @param string $projectName
     * @return int the project id
     */
    public function createProject($projectName)
    {
        return 42;
    }
}
