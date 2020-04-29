<?php

use Leankoala\LeankoalaClient\Client\ApiError;
use Leankoala\LeankoalaClient\Repository\UserRepository;

$jsonWebTokenIdentifier = 'um_oauth_provider_jwt';

include_once __DIR__ . '/../_includes/autoload.php';

/** @var UserRepository $userRepository */
$userRepository = $client->getRepository('User');

try {
    $userId = $userRepository->createUser(
        getenv('um_provider'),
        'Nils_' . time(),
        md5(time() . rand(0, 500000)),
        'nils.langner_' . time() . '@leankoala.com',
        ['company_id' => getenv('um_company_id')]
    );
} catch (ApiError $e) {
    echo "\n";
    echo "  Error occurred: " . $e->getMessage();
    echo "\n\n             Url: " . $e->getUrl();
    echo "\n\n         Payload: " . json_encode($e->getPayload());
    echo "\n\n";
    die;
}



var_dump($userId);
