<?php

use Leankoala\LeankoalaClient\Client;
use Leankoala\LeankoalaClient\Client\ApiError;
use Leankoala\LeankoalaClient\Repository\CheckRepository;

include_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$client = new Client(getenv('username'), getenv('password'), getenv('environment'));

if (count($argv) !== 3) {
    echo "\n Usage: php " . $argv[0] . " systemId checklistName \n\n";
    die;
}

$systemId = (int)$argv[1];
$checklistName = $argv[2];

try {
    /** @var CheckRepository $checkRepository */
    $checkRepository = $client->getRepository('Check');
    $addedCollections = $checkRepository->addByChecksByChecklist($systemId, $checklistName);

    echo "\n  " . $addedCollections . ' collection(s) were added to system with id ' . $systemId . ". \n\n";

} catch (ApiError $e) {
    echo "\n";
    echo "  Error occurred: " . $e->getMessage();
    echo "\n\n";
}
