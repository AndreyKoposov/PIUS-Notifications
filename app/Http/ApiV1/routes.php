<?php

use App\Http\ApiV1\Modules\Notifications\Controllers\NotificationsController;
use App\Http\ApiV1\Modules\Notifications\Controllers\TypesController;

$generatedRoutes = __DIR__ . "/OpenApiGenerated/routes.php";
if (file_exists($generatedRoutes)) { // prevents your app and artisan from breaking if there is no autogenerated Route file for some reason.
    require $generatedRoutes;
}

//Route::get('send/', [NotificationsController::class, 'send']);
Route::get('send/{id}', [NotificationsController::class, 'send']);

Route::post('notifications/add', [NotificationsController::class, 'add']);

Route::post('types/add', [TypesController::class, 'add']);
