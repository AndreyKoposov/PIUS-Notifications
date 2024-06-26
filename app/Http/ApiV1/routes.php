<?php

use App\Http\ApiV1\Modules\Notifications\Controllers\NotificationsController;
use App\Http\ApiV1\Modules\Notifications\Controllers\TypesController;
use App\Http\ApiV1\Modules\Notifications\Controllers\SubscribesController;

$generatedRoutes = __DIR__ . "/OpenApiGenerated/routes.php";
if (file_exists($generatedRoutes)) { // prevents your app and artisan from breaking if there is no autogenerated Route file for some reason.
    require $generatedRoutes;
}



Route::group(['prefix' => 'notifications'], function () {
    Route::get('/{id}', [NotificationsController::class, 'get']);
    Route::post('/', [NotificationsController::class, 'add']);
    Route::delete('/{id}', [NotificationsController::class, 'delete']);
    Route::put('/{id}', [NotificationsController::class, 'replace']);
    Route::patch('/{id}', [NotificationsController::class, 'patch']);

    Route::get('/send/{id}', [NotificationsController::class, 'send']);
});

Route::group(['prefix' => 'types'], function () {
    Route::get('/{id}', [TypesController::class, 'get']);
    Route::post('/', [TypesController::class, 'add']);
    Route::delete('/{id}', [TypesController::class, 'delete']);
    Route::put('/{id}', [TypesController::class, 'replace']);
    Route::patch('/{id}', [TypesController::class, 'update']);
});

Route::group(['prefix' => 'subscribes'], function () {
    Route::get('/{id}', [SubscribesController::class, 'get']);
    Route::post('/', [SubscribesController::class, 'add']);
    Route::delete('/{id}', [SubscribesController::class, 'delete']);
    Route::put('/{id}', [SubscribesController::class, 'replace']);
    Route::patch('/{id}', [SubscribesController::class, 'update']);
});
