<?php 

use App\Http\ApiV1\Support\Tests\ApiV1ComponentTestCase;
use App\Domain\Notifications\Models\Subscribe;
use App\Domain\Notifications\Models\NotificationType;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\deleteJson;

uses(ApiV1ComponentTestCase::class);
uses()->group('component');

$typeId = null;

/*beforeAll(function() {
    $type = new NotificationType();
    $type->course_id = 123;
    $type->save();
    $typeId = $type->id;
});*/

test('POST /api/v1/subscribes create subscribe success', function () {
    $type = new NotificationType();
    $type->course_id = 123;
    $type->save();
    $typeId = $type->id;

    $request = [
        'user_id' => 456,
        'type_id' => $typeId
    ];

    postJson('/api/v1/subscribes', $request)
        ->assertStatus(200)
        ->assertJsonPath('data.notification_type_id', $request['type_id'])
        ->assertJsonPath('data.user_id', $request['user_id']);

    assertDatabaseHas(Subscribe::class, [
        'notification_type_id' => $request['type_id'],
        'user_id' => $request['user_id']
    ]);
});

test('GET /api/v1/subscribes/{id} get subscribe success', function () {
    $type = new NotificationType();
    $type->course_id = 123;
    $type->save();
    $typeId = $type->id;

    $subscribe = new Subscribe();
    $subscribe->user_id = 456;
    $subscribe->notification_type_id = $typeId;
    $subscribe->save();
    $id = $subscribe->id;

    getJson("/api/v1/subscribes/{$id}")
        ->assertStatus(200)
        ->assertJsonPath('data.user_id', $subscribe->user_id)
        ->assertJsonPath('data.notification_type_id', $subscribe->notification_type_id);
});

test('PUT /api/v1/subscribes/{id} put subscribe success', function () {
    $type = new NotificationType();
    $type->course_id = 123;
    $type->save();
    $typeId = $type->id;

    $subscribe = new Subscribe();
    $subscribe->user_id = 456;
    $subscribe->notification_type_id = $typeId;
    $subscribe->save();
    $id = $subscribe->id;

    $request = [
        'user_id' => 777,
        'type_id' => $typeId
    ];
    
    putJson("/api/v1/subscribes/{$id}", $request)
        ->assertStatus(200)
        ->assertJsonPath('data.user_id', $request['user_id'])
        ->assertJsonPath('data.notification_type_id', $request['type_id']);

    assertDatabaseHas(Subscribe::class, [
        'user_id' => $request['user_id'],
        'notification_type_id' => $request['type_id']
    ]);
});

test('PATCH /api/v1/subscribes/{id} patch subscribe success', function () {
    $type = new NotificationType();
    $type->course_id = 123;
    $type->save();
    $typeId = $type->id;

    $subscribe = new Subscribe();
    $subscribe->user_id = 456;
    $subscribe->notification_type_id = $typeId;
    $subscribe->save();
    $id = $subscribe->id;

    $request = [
        'user_id' => 666
    ];

    
    patchJson("/api/v1/subscribes/{$id}", $request)
        ->assertStatus(200)
        ->assertJsonPath('data.user_id', $request['user_id'])
        ->assertJsonPath('data.notification_type_id', $typeId);

    assertDatabaseHas(Subscribe::class, [
        'user_id' => $request['user_id'],
        'notification_type_id' => $typeId
    ]);
});

test('DELETE /api/v1/subscribes/{id} delete subscribe success', function () {
    $type = new NotificationType();
    $type->course_id = 123;
    $type->save();
    $typeId = $type->id;

    $subscribe = new Subscribe();
    $subscribe->user_id = 456;
    $subscribe->notification_type_id = $typeId;
    $subscribe->save();
    $id = $subscribe->id;
    
    deleteJson("/api/v1/subscribes/{$id}")
        ->assertStatus(200)
        ->assertJsonPath('data', null);

    assertDatabaseMissing(Subscribe::class, [
        'id' => $id
    ]);
});

?>