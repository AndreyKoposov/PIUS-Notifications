<?php

namespace App\Http\ApiV1\Modules\Notifications\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\Notifications\Models\NotificationType;


class TypesController
{
    public function add(Request $request) {
        $courseId = $request->request->get('course_id');

        $notification = NotificationType::create([
            'course_id' => $courseId
        ]);

        return response()->json(['id' => $notification->id]);
    }
}
