<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\GroupDto;
use Dvomaks\PromuaApi\Exceptions\PromuaApiException;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Illuminate\Http\Client\ConnectionException;

/**
 * GroupsService provides methods to interact with group functionality of the Promua API.
 * It allows retrieving groups list, getting and updating group translations.
 */
readonly class GroupsService
{
    /**
     * GroupsService constructor.
     *
     * @param  PromuaApiClient  $client  The API client used to make requests to the Promua API
     */
    public function __construct(private PromuaApiClient $client) {}

    /**
     * Get a list of groups
     *
     * @param  string|null  $lastModifiedFrom  Start date in ISO-8601 format
     * @param  string|null  $lastModifiedTo  End date in ISO-8601 format
     * @param  int|null  $limit  Limit the number of groups
     * @param  int|null  $lastId  Limit the selection of groups with identifiers not higher than the specified one
     * @return GroupDto[] Array of group data transfer objects
     *
     * @throws PromuaApiException
     * @throws ConnectionException
     */
    public function getList(
        ?string $lastModifiedFrom = null,
        ?string $lastModifiedTo = null,
        ?int $limit = null,
        ?int $lastId = null
    ): array {
        $params = array_filter([
            'last_modified_from' => $lastModifiedFrom,
            'last_modified_to' => $lastModifiedTo,
            'limit' => $limit,
            'last_id' => $lastId,
        ]);

        $response = $this->client->get('/groups/list', $params);

        $groups = [];
        foreach ($response['groups'] ?? [] as $groupData) {
            $groups[] = GroupDto::fromArray($groupData);
        }

        return $groups;
    }

    /**
     * Get group translation
     *
     * @param  int  $id  Group identifier
     * @param  string  $lang  Translation language
     * @return array Array with translation of group name and description
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function getTranslation(int $id, string $lang): array
    {
        return $this->client->get("/groups/translation/$id", [
            'lang' => $lang,
        ]);
    }

    /**
     * Update group translation
     *
     * @param  int  $groupId  Group identifier
     * @param  string  $lang  Translation language
     * @param  string|null  $name  Name translation
     * @param  string|null  $description  Description translation
     * @return array Array with operation status
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function updateTranslation(int $groupId, string $lang, ?string $name = null, ?string $description = null): array
    {
        $params = [
            'group_id' => $groupId,
            'lang' => $lang,
        ];

        if ($name !== null) {
            $params['name'] = $name;
        }

        if ($description !== null) {
            $params['description'] = $description;
        }

        return $this->client->put('/groups/translation', $params);
    }
}
