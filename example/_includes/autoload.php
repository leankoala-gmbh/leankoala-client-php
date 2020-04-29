<?php

use Leankoala\LeankoalaClient\Client;

include_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../')->load();

global $jsonWebTokenIdentifier;

if (!is_null($jsonWebTokenIdentifier)) {
    $client = Client::createByJwt(getenv($jsonWebTokenIdentifier), getenv('environment'));
} else {
    $client = Client::createByCredentials(getenv('username'), getenv('password'), getenv('environment'));
}
