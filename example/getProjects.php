<?php

use Leankoala\ApiClient\Client;
use Leankoala\ApiClient\Exception\BadRequestException;
use Leankoala\ApiClient\Repository\Entity\ProjectRepository;

include_once __DIR__ . '/../vendor/autoload.php';

try {
    $client = new Client(Client::ENVIRONMENT_DEVELOP);
    $client->connect('nils', 'nils', true);
    /** @var ProjectRepository $repo */
    $repo = $client->getRepository('project');

    $projects = $repo->search(['user' => $client->getClusterUser()['id']]);

} catch (BadRequestException $e) {
    if ($e->hasResponse()) {
        echo "\n\n" . $e->getResponse()->getBody();
        echo "\n\n Status Code: " . $e->getResponse()->getStatusCode();
    }
    var_dump($e->getMessage());
    echo "\n\nUnable to send request. Message: " . $e->getMessage() . ", URL: " . $e->getUrl() . ', method: ' . $e->getMethod() . ', data: ' . json_encode($e->getData());

} catch (Exception $exception) {
    echo $exception->getMessage();
}

var_dump($projects);
