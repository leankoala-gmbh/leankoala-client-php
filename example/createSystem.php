<?php

use Leankoala\LeankoalaClient\Client;
use Leankoala\LeankoalaClient\Repository\ProjectRepository;
use Leankoala\LeankoalaClient\Repository\SystemRepository;

include_once __DIR__ . '/../vendor/autoload.php';

$client = new Client('nils.langner', 'langner', Client::ENVIRONMENT_STAGE);

/** @var ProjectRepository $projectRepository */
$projectRepository = $client->getRepository('project');
$projectId = $projectRepository->createProject('New project');

/** @var SystemRepository $systemRepository */
$systemRepository = $client->getRepository('system');
$systemId = $systemRepository->createSystem($projectId, 'New project');

var_dump($projectId);
var_dump($systemId);
