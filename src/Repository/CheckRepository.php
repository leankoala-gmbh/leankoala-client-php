<?php

namespace Leankoala\LeankoalaClient\Repository;

use Leankoala\LeankoalaClient\Client\ApiError;

class CheckRepository extends BaseRepository
{
    const ENDPOINT_ADD_CHECKS_BY_CHECKLIST = '/v1/check/checks/{{system}}/checklist';

    /**
     * @param $systemId
     * @param $checklistNameOrId
     *
     * @return int number of collections that where added
     *
     * @throws ApiError
     */
    public function addByChecksByChecklist($systemId, $checklistNameOrId)
    {
        $payload = [
            'system' => $systemId,
            'checklist' => $checklistNameOrId
        ];

        $resultData = $this->getConnection()->sendPost(self::ENDPOINT_ADD_CHECKS_BY_CHECKLIST, $payload);

        return $resultData['collection_count'];
    }
}
