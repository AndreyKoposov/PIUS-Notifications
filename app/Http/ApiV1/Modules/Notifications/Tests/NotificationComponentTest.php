<?php 

use App\Http\ApiV1\Support\Tests\ApiV1ComponentTestCase;
use App\Domain\Notifications\Models\Notification;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

uses(ApiV1ComponentTestCase::class);
uses()->group('component');

/*test('POST /api/v1/notifications create success', function () {
    $request = [
        'sent_time' => '2024-04-12T17:02:11',
        'content' => 'test content',
        'type_id' => 1,
        'user_id' => 123
    ];

    postJson('/api/v1/notifications', $request)
        ->assertStatus(200)
        ->assertJsonPath('data.sent_time', $request['send_time'])
        ->assertJsonPath('data.content', $request['content'])
        ->assertJsonPath('data.type_id', $request['type_id'])
        ->assertJsonPath('data.user_id', $request['user_id']);

    assertDatabaseHas(Notifications::class, [
        'content' => $request['content'],
        'type_id' => $request['type_id'],
        'user_id' => $request['user_id'],
        'send_time' => $request['send_time'],
    ]);
});*/

test('GET /api/v1/notifications/{id} get notification success', function () {
    /** @var Notification $notification */
    $notification = new Notification();

    $notification->content = 'test content';
    $notification->notification_type_id = 1;
    $notification->send_time = '2024-04-12T17:02:11';
    $notification->user_id = 0;

    $notification->save();
    $id = $notification->id;

    getJson("/api/v1/notifications/{$id}")
        ->assertStatus(200)
        ->assertJsonPath('data.content', $notification->content)
        ->assertJsonPath('data.type_id', $notification->notification_type_id);
});

?>