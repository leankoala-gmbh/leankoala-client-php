<?php

use Leankoala\ApiClient\Client;
use Leankoala\ApiClient\Exception\BadRequestException;
use Leankoala\ApiClient\Repository\Entity\ApplicationRepository;

include_once __DIR__ . '/../vendor/autoload.php';

try {
    $client = new Client(Client::ENVIRONMENT_DEVELOP);
    $client->connect('nils', 'nils', false);
    /** @var ApplicationRepository $repo */
    $repo = $client->getRepository('application');
    $cluster = $repo->getPrimaryCluster('koality', []);
} catch (BadRequestException $e) {
    if ($e->hasResponse()) {
        // echo "\n\n" . $e->getResponse()->getBody();
        echo "\n\n Status Code: " . $e->getResponse()->getStatusCode();
    }
    echo "\n\nUnable to send request. URL: " . $e->getUrl() . ', method: ' . $e->getMethod() . ', data: ' . json_encode($e->getData());

} catch (Exception $exception) {
    echo $exception->getMessage();
}

var_dump($cluster);
