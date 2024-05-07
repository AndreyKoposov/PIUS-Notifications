<?php

namespace App\Http\ApiV1\Modules\Notifications\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\Notifications\Models\Subscribe;
use App\Domain\Notifications\Models\Notification;
use App\Domain\Notifications\Models\NotificationType;


class SubscribesController
{
    public function add(Request $request) {
        $typeId = $request->request->get('type_id');
        $userId = $request->request->get('user_id');
        $errors = [];

        if($typeId === null || !is_numeric($typeId))
            $errors[] = ['code' => "400", 'message' => "type ID cannot be null or empty"];
        else
        if(NotificationType::find($typeId) === null)
            $errors[] = ['code' => "404", 'message' => "type with id {$typeId} does not exist"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors])->setStatusCode(400);

        $subscribe = Subscribe::create([
            'notification_type_id' => $typeId,
            'user_id' => $userId
        ]);

        return response()->json(['data' => $subscribe, 'errors' => $errors]);
    }

    public function get(Request $request) {
        $id = $request->route('id');
        $subscribe = Subscribe::find($id);
        $errors = [];

        if($subscribe === null)
            $errors[] = ['code' => "404", 'message' => "subscribe with ID <{$id}> does not exist"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors])->setStatusCode(404);

        $include = $request->input('include');
        if($include === 'type') {
            $subscribe->type;
        }

        return response()->json(['data' => $subscribe, 'errors' => $errors]);
    }

    public function delete(Request $request) {
        $id = $request->route('id');
        $subscribe = Subscribe::find($id);
        $errors = [];

        if($subscribe !== null)
            $subscribe->delete();

        return response()->json(['data' => null, 'errors' => $errors]);
    }
}
