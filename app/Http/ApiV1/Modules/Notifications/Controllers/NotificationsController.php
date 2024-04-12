<?php

namespace App\Http\ApiV1\Modules\Notifications\Controllers;

use Illuminate\Http\Request;
use App\Notifications\EmailNotification;
use App\Domain\Notifications\Models\Notification;

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

        $notification = Notification::create([
            'content' => $content,
            'notification_type_id' => $notificationType
        ]);

        return response()->json(['id' => $notification->id]);
    }
}
