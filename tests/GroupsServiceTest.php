<?php

use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Dvomaks\PromuaApi\Services\GroupsService;
use Dvomaks\PromuaApi\Dto\GroupDto;

beforeEach(function () {
    $this->mockClient = Mockery::mock(PromuaApiClient::class);
    $this->groupsService = new GroupsService($this->mockClient);
});

afterEach(function () {
    Mockery::close();
});

test('getList returns array of GroupDto', function () {
    $mockResponse = [
        'groups' => [
            [
                'id' => 1,
                'name' => 'Electronics',
                'name_multilang' => [
                    'uk' => 'Електроніка',
                    'ru' => 'Электроника'
                ],
                'description' => 'Electronic devices and accessories',
                'description_multilang' => [
                    'uk' => 'Електронні пристрої та аксесуари',
                    'ru' => 'Электронные устройства и аксессуары'
                ],
                'image' => 'https://example.com/images/electronics.jpg',
                'parent_group_id' => null
            ]
        ]
    ];
    
    $this->mockClient
        ->shouldReceive('get')
        ->with('/groups/list', [])
        ->andReturn($mockResponse);
    
    $result = $this->groupsService->getList();
    
    expect($result)->toBeArray();
    expect($result[0])->toBeInstanceOf(GroupDto::class);
    expect($result[0]->id)->toBe(1);
    expect($result[0]->name)->toBe('Electronics');
    expect($result[0]->name_multilang['uk'])->toBe('Електроніка');
});

test('getList with parameters returns array of GroupDto', function () {
    $lastModifiedFrom = '2023-01-01T00:00:00';
    $lastModifiedTo = '2023-12-31T23:59:59';
    $limit = 10;
    $lastId = 10;
    
    $mockResponse = [
        'groups' => [
            [
                'id' => 2,
                'name' => 'Books',
                'name_multilang' => [
                    'uk' => 'Книги',
                    'ru' => 'Книги'
                ],
                'description' => 'Various books and publications',
                'description_multilang' => [
                    'uk' => 'Різні книги та видання',
                    'ru' => 'Различные книги и издания'
                ],
                'image' => 'https://example.com/images/books.jpg',
                'parent_group_id' => 1
            ]
        ]
    ];
    
    $this->mockClient
        ->shouldReceive('get')
        ->with('/groups/list', [
            'last_modified_from' => $lastModifiedFrom,
            'last_modified_to' => $lastModifiedTo,
            'limit' => $limit,
            'last_id' => $lastId,
        ])
        ->andReturn($mockResponse);
    
    $result = $this->groupsService->getList($lastModifiedFrom, $lastModifiedTo, $limit, $lastId);
    
    expect($result)->toBeArray();
    expect($result[0])->toBeInstanceOf(GroupDto::class);
    expect($result[0]->id)->toBe(2);
    expect($result[0]->name)->toBe('Books');
    expect($result[0]->parent_group_id)->toBe(1);
});

test('getTranslation returns translation data', function () {
    $groupId = 1;
    $lang = 'uk';
    $mockResponse = [
        'name' => 'Електроніка',
        'description' => 'Електронні пристрої та аксесуари'
    ];
    
    $this->mockClient
        ->shouldReceive('get')
        ->with("/groups/translation/{$groupId}", [
            'lang' => $lang
        ])
        ->andReturn($mockResponse);
    
    $result = $this->groupsService->getTranslation($groupId, $lang);
    
    expect($result)->toBeArray();
    expect($result['name'])->toBe('Електроніка');
    expect($result['description'])->toBe('Електронні пристрої та аксесуари');
});

test('updateTranslation returns success status', function () {
    $groupId = 1;
    $lang = 'uk';
    $name = 'Електроніка';
    $description = 'Електронні пристрої та аксесуари';
    $mockResponse = [
        'status' => 'success'
    ];
    
    $this->mockClient
        ->shouldReceive('put')
        ->with('/groups/translation', [
            'group_id' => $groupId,
            'lang' => $lang,
            'name' => $name,
            'description' => $description
        ])
        ->andReturn($mockResponse);
    
    $result = $this->groupsService->updateTranslation($groupId, $lang, $name, $description);
    
    expect($result)->toBeArray();
    expect($result['status'])->toBe('success');
});