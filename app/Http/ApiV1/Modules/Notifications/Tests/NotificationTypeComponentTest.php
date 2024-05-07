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
        ->assertJsonPath('data.course_id', $request['course_id']);

    assertDatabaseHas(NotificationType::class, [
        'course_id' => $request['course_id']
    ]);
});

test('GET /api/v1/types/{id} get type success', function () {
    $type = new NotificationType();
    $type->course_id = 456;
    $type->save();
    $id = $type->id;

    getJson("/api/v1/types/{$id}")
        ->assertStatus(200)
        ->assertJsonPath('data.course_id', $type->course_id);
});

test('PUT /api/v1/types/{id} put type success', function () {
    $type = new NotificationType();
    $type->course_id = 123;
    $type->save();
    $id = $type->id;

    $request = [
        'course_id' => 456
    ];

    
    putJson("/api/v1/types/{$id}", $request)
        ->assertStatus(200)
        ->assertJsonPath('data.course_id', $request['course_id']);

    assertDatabaseHas(NotificationType::class, [
        'course_id' => $request['course_id']
    ]);
});

test('PATCH /api/v1/types/{id} patch type success', function () {
    $type = new NotificationType();
    $type->course_id = 123;
    $type->save();
    $id = $type->id;

    $request = [
        'course_id' => 456
    ];
    
    patchJson("/api/v1/types/{$id}", $request)
        ->assertStatus(200)
        ->assertJsonPath('data.course_id', $request['course_id']);

    assertDatabaseHas(NotificationType::class, [
        'course_id' => $request['course_id']
    ]);
});

test('DELETE /api/v1/types/{id} delete type success', function () {
    $type = new NotificationType();
    $type->course_id = 123;
    $type->save();
    $id = $type->id;
    
    deleteJson("/api/v1/types/{$id}")
        ->assertStatus(200)
        ->assertJsonPath('data', null);

    assertDatabaseMissing(NotificationType::class, [
        'id' => $id
    ]);
});

?>