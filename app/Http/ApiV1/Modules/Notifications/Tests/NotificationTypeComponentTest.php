<?php 

use App\Http\ApiV1\Support\Tests\ApiV1ComponentTestCase;
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

test('POST /api/v1/types create success', function () {

    $request = [
        'course_id' => 456
    ];

    postJson('/api/v1/types', $request)
        ->assertStatus(200)
        ->assertJsonPath('data.send_time', $request['course_id']);

    assertDatabaseHas(Notification::class, [
        'course_id' => $request['course_id']
    ]);
});

test('GET /api/v1/types/{id} get type success', function () {
    /** @var Notification $notification */
    $type = new NotificationType();
    $type->course_id = 456;
    $type->save();
    $id = $type->id;

    getJson("/api/v1/types/{$id}")
        ->assertStatus(200)
        ->assertJsonPath('data.course_id', $notification->content);
});

test('PUT /api/v1/notifications/{id} put notification success', function () {
    $type = new NotificationType();
    $type->course_id = 123;
    $type->save();
    $type_id = $type->id;

    $notification = new Notification();

    $notification->content = 'test content';
    $notification->notification_type_id = $type_id;
    $notification->send_time = '2024-04-12T17:02:11';
    $notification->user_id = 4444;

    $notification->save();
    $id = $notification->id;

    $request = [
        'send_time' => '2024-04-12T17:02:11',
        'content' => 'new test content',
        'type_id' => $type_id
    ];

    
    putJson("/api/v1/notifications/{$id}", $request)
        ->assertStatus(200)
        ->assertJsonPath('data.send_time', $request['send_time'])
        ->assertJsonPath('data.content', $request['content'])
        ->assertJsonPath('data.notification_type_id', $request['type_id'])
        ->assertJsonPath('data.user_id', 0);

    assertDatabaseHas(Notification::class, [
        'content' => $request['content'],
        'notification_type_id' => $request['type_id'],
        'user_id' => 0,
        'send_time' => $request['send_time'],
    ]);
});

test('PATCH /api/v1/notifications/{id} patch notification success', function () {
    $type = new NotificationType();
    $type->course_id = 123;
    $type->save();
    $type_id = $type->id;

    $notification = new Notification();

    $notification->content = 'test content';
    $notification->notification_type_id = $type_id;
    $notification->send_time = '2024-04-12T17:02:11';
    $notification->user_id = 4444;

    $notification->save();
    $id = $notification->id;

    $request = [
        'send_time' => '2024-04-12T17:02:11',
        'content' => 'new test content',
        'type_id' => $type_id
    ];

    
    patchJson("/api/v1/notifications/{$id}", $request)
        ->assertStatus(200)
        ->assertJsonPath('data.send_time', $request['send_time'])
        ->assertJsonPath('data.content', $request['content'])
        ->assertJsonPath('data.notification_type_id', $request['type_id'])
        ->assertJsonPath('data.user_id', 4444);

    assertDatabaseHas(Notification::class, [
        'content' => $request['content'],
        'notification_type_id' => $request['type_id'],
        'user_id' => 4444,
        'send_time' => $request['send_time'],
    ]);
});

test('DELETE /api/v1/notifications/{id} delete notification success', function () {
    $type = new NotificationType();
    $type->course_id = 123;
    $type->save();
    $type_id = $type->id;

    $notification = new Notification();

    $notification->content = 'test content';
    $notification->notification_type_id = $type_id;
    $notification->send_time = '2024-04-12T17:02:11';
    $notification->user_id = 4444;

    $notification->save();
    $id = $notification->id;
    
    deleteJson("/api/v1/notifications/{$id}")
        ->assertStatus(200)
        ->assertJsonPath('data', null);

    assertDatabaseMissing(Notification::class, [
        'id' => $id
    ]);
});

?>