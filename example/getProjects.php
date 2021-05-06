<?php

use Leankoala\ApiClient\Client;
use Leankoala\ApiClient\Exception\BadRequestException;
use Leankoala\ApiClient\Repository\Entity\Auth2ApplicationRepository;

include_once __DIR__ . '/../vendor/autoload.php';

try {
    $client = new Client(Client::ENVIRONMENT_DEVELOP);
    $client->connect('nils', 'nils');
    /** @var Auth2ApplicationRepository $repo */
    $repo = $client->getRepository('auth2application');
    $repo->getPrimaryCluster('koality', []);
} catch (BadRequestException $e) {
    echo "Unable to send request. URL: " . $e->getUrl() . ', method: ' . $e->getMethod() . ', data: ' . json_encode($e->getData());
} catch (Exception $exception) {
    echo $exception->getMessage();
}
