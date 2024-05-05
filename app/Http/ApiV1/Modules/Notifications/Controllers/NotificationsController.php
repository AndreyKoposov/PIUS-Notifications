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

        if($notificationType === null or !is_numeric($notificationTyp))
            $errors[] = ['code' => 1, 'message' => "type cannot be null"];
        else
        if(NotificationType::find($notificationType) === null)
            $errors[] = ['code' => 1, 'message' => "type with id {$notificationType} does not exist"];
        if($content === null)
            $errors[] = ['code' => 1, 'message' => "content cannot be null"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors]);

        $notification = Notification::create([
            'content' => $content,
            'notification_type_id' => $notificationType
        ]);

        return response()->json(['data' => $notification]);
    }

    public function replace(Request $request) {
        $id = $request->route('id');
        $content = $request->request->get('content');
        $notificationType = $request->request->get('type_id');
        $sendTime = $request->request->get('send_time');
        $userId = $request->request->get('user_id');
        $errors = [];

        $notification = Notification::find($id);

        if($notificationType === null || !is_numeric($notificationType))
            $errors[] = ['code' => 1, 'message' => "type cannot be null or empty"];
        else
        if(NotificationType::find($notificationType) === null)
            $errors[] = ['code' => 1, 'message' => "type with id <{$notificationType}> does not exist"];
        if($content === null)
            $errors[] = ['code' => 1, 'message' => "content cannot be null"];
        if(Notification::find($id) === null)
            $errors[] = ['code' => 404, 'message' => "notification with id {$id} does not exist"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors]);

        $notification->content = $content;
        $notification->notification_type_id = $notificationType;
        $notification->user_id = $userId;
        $notification->send_time = $sendTime;
        $notification->save();

        return response()->json(['data' => $notification]);
    }

    public function patch(Request $request) {
        $id = $request->route('id');
        $content = $request->request->get('content');
        $notificationType = $request->request->get('type_id');
        $sendTime = $request->request->get('send_time');
        $userId = $request->request->get('user_id');
        $errors = [];

        $notification = Notification::find($id);

        if($notificationType !== null and !is_numeric($notificationType))
            $errors[] = ['code' => 1, 'message' => "type cannot be empty"];
        if($notificationType !== null and NotificationType::find($notificationType) === null)
            $errors[] = ['code' => 1, 'message' => "type with id <{$notificationType}> does not exist"];
        if(Notification::find($id) === null)
            $errors[] = ['code' => 404, 'message' => "notification with id {$id} does not exist"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors]);

        if($content !== null) $notification->content = $content;
        if($notificationType !== null) $notification->notification_type_id = $notificationType;
        if($userId !== null) $notification->user_id = $userId;
        if($sendTime !== null) $notification->send_time = $sendTime;
        $notification->save();

        return response()->json(['data' => $notification]);
    }

    public function get(Request $request) {
        $id = $request->route('id');
        $notification = Notification::find($id);
        $errors = [];

        if($notification === null)
            $errors[] = ['code' => 404, 'message' => "notification with id {$id} does not exist"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors]);

        $include = $request->input('include');
        if($include === 'type') {
            $notification->type;
        }

        return response()->json(['data' => $notification]);
    }

    public function delete(Request $request) {
        $id = $request->route('id');

        $notification = Notification::find($id)->delete();

        return response()->json(['data' => null]);
    }
}
