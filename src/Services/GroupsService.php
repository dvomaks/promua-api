<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\GroupDto;
use Dvomaks\PromuaApi\Http\PromuaApiClient;

class GroupsService
{
    public function __construct(
        private PromuaApiClient $client
    ) {}

    /**
     * Отримує список груп
     *
     * @param  string|null  $lastModifiedFrom  Дата початку у форматі ISO-8601
     * @param  string|null  $lastModifiedTo  Дата завершення у форматі ISO-8601
     * @param  int|null  $limit  Обмеження кількості груп
     * @param  int|null  $lastId  Обмежити вибірку груп з ідентифікаторами не вище вказаного
     * @return GroupDto[]
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
     * Отримує переклад групи
     *
     * @param  int  $id  Ідентифікатор групи
     * @param  string  $lang  Мова перекладу
     * @return array Масив з перекладом назви та опису групи
     */
    public function getTranslation(int $id, string $lang): array
    {
        $response = $this->client->get("/groups/translation/{$id}", [
            'lang' => $lang,
        ]);

        return $response;
    }

    /**
     * Оновлює переклад групи
     *
     * @param  int  $groupId  Ідентифікатор групи
     * @param  string  $lang  Мова перекладу
     * @param  string|null  $name  Переклад назви
     * @param  string|null  $description  Переклад опису
     * @return array Масив зі статусом операції
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
