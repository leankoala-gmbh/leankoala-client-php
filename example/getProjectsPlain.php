<?php

use Leankoala\ApiClient\Client;

include_once __DIR__ . '/../vendor/autoload.php';

$client = new Client(Client::ENVIRONMENT_DEVELOP);
$client->connect('nils', 'nils', true);
$repo = $client->getRepository('project');
$projects = $repo->search(['user' => $client->getClusterUser()['id']]);
var_dump($projects);
