<?php

namespace App\Http\ApiV1\Modules\Notifications\Controllers;

use Illuminate\Http\Request;
use App\Notifications\EmailNotification;
use App\Domain\Notifications\Models\Notification;
use App\Domain\Notifications\Models\NotificationType;

class NotificationsController
{
    public function send(Request $request) {
        //$id = $request->request->get('id');
        $id = $request->route('id');
        $notification = Notification::find($id);

        $notification->notify(new EmailNotification());
    }

    public function add(Request $request) {
        $content = $request->request->get('content');
        $notificationType = $request->request->get('type_id');
        $errors = [];

        if(NotificationType::find($notificationType) === null)
            $errors[] = ['code' => 1, 'message' => "type with id {$notificationType} does not exist"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors]);

        $notification = Notification::create([
            'content' => $content,
            'notification_type_id' => $notificationType
        ]);

        return response()->json(['data' => $notification]);
    }

    public function get(Request $request) {
        $id = $request->route('id');
        $notification = Notification::find($id);

        $include = $request->input('include');
        if($include === 'type') {
            $notification->type;
        }

        return response()->json(['data' => $notification]);
    }

    public function delete(Request $request) {
        $id = $request->route('id');

        $notification = Notification::find($id)->delete();

        return response()->json(['data' => 'success']);
    }
}
