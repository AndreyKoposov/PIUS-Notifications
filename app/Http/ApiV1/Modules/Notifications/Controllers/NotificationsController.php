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
        $sendTime = $request->request->get('send_time');
        $userId = $request->request->get('user_id');
        $errors = [];

        if($notificationType === null or !is_numeric($notificationType))
            $errors[] = ['code' => "400", 'message' => "type cannot be null"];
        else
        if(NotificationType::find($notificationType) === null)
            $errors[] = ['code' => "404", 'message' => "type with id {$notificationType} does not exist"];
        if($content === null)
            $errors[] = ['code' => "400", 'message' => "content cannot be null"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors]);

        if($sendTime === null) $sendTime = '2024-04-12T17:02:11';
        if($userId === null)   $userId = 0;

        $notification = Notification::create([
            'content' => $content,
            'notification_type_id' => $notificationType,
            'send_time' => $sendTime,
            'user_id' => $userId
        ]);

        return response()->json(['data' => $notification, 'errors' => $errors]);
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
            $errors[] = ['code' => "400", 'message' => "type cannot be null or empty"];
        else
        if(NotificationType::find($notificationType) === null)
            $errors[] = ['code' => "404", 'message' => "type with id <{$notificationType}> does not exist"];
        if($content === null)
            $errors[] = ['code' => "400", 'message' => "content cannot be null"];
        if(Notification::find($id) === null)
            $errors[] = ['code' => "404", 'message' => "notification with id {$id} does not exist"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors]);


        if($sendTime === null) $sendTime = '2024-04-12T17:02:11';
        if($userId === null)   $userId = 0;
        
        $notification->content = $content;
        $notification->notification_type_id = $notificationType;
        $notification->user_id = $userId;
        $notification->send_time = $sendTime;
        $notification->save();

        return response()->json(['data' => $notification, 'errors' => $errors]);
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
            $errors[] = ['code' => "400", 'message' => "type cannot be empty"];
        if($notificationType !== null and NotificationType::find($notificationType) === null)
            $errors[] = ['code' => "404", 'message' => "type with id <{$notificationType}> does not exist"];
        if(Notification::find($id) === null)
            $errors[] = ['code' => "404", 'message' => "notification with id {$id} does not exist"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors]);

        if($content !== null) $notification->content = $content;
        if($notificationType !== null) $notification->notification_type_id = $notificationType;
        if($userId !== null) $notification->user_id = $userId;
        if($sendTime !== null) $notification->send_time = $sendTime;
        $notification->save();

        return response()->json(['data' => $notification, 'errors' => $errors]);
    }

    public function get(Request $request) {
        $id = $request->route('id');
        $notification = Notification::find($id);
        $errors = [];

        if($notification === null)
            $errors[] = ['code' => "404", 'message' => "notification with id {$id} does not exist"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors])->setStatusCode(404);

        $include = $request->input('include');
        if($include === 'type') {
            $notification->type;
        }

        $errors[] = ['code' => "200", 'message' => "ok"];
        return response()->json(['data' => $notification, 'errors' => $errors]);
    }

    public function delete(Request $request) {
        $id = $request->route('id');
        $errors = [];

        Notification::find($id)->delete();

        return response()->json(['data' => null, 'errors' => $errors]);
    }
}
