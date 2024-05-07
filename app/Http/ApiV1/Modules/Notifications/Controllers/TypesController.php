<?php

namespace App\Http\ApiV1\Modules\Notifications\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\Notifications\Models\NotificationType;
use App\Domain\Notifications\Models\Subscribe;


class TypesController
{
    public function add(Request $request) {
        $courseId = $request->request->get('course_id');
        $errors = [];

        if($courseId === null || !is_numeric($courseId))
            $errors[] = ['code' => "400", 'message' => "course ID cannot be null or empty"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors])->setStatusCode(400);

        $type = NotificationType::create([
            'course_id' => $courseId
        ]);

        return response()->json(['data' => $type, 'errors' => $errors]);
    }

    public function replace(Request $request) {
        $id = $request->route('id');
        $courseId = $request->request->get('course_id');
        $type = NotificationType::find($id);
        $errors = [];

        if($courseId === null || !is_numeric($courseId))
            $errors[] = ['code' => "400", 'message' => "course ID cannot be null or empty"];
        if($type === null)
            $errors[] = ['code' => "404", 'message' => "type with ID <{$id}> does not exist"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors])->setStatusCode(400);

        $type->course_id = $courseId;
        $type->save();

        return response()->json(['data' => $type, 'errors' => $errors]);
    }

    public function update(Request $request) {
        $id = $request->route('id');
        $courseId = $request->request->get('course_id');
        $type = NotificationType::find($id);
        $errors = [];

        if($courseId === null || !is_numeric($courseId))
            $errors[] = ['code' => "400", 'message' => "course ID cannot be null or empty"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors])->setStatusCode(400);

        $type->course_id = $courseId;
        $type->save();

        return response()->json(['data' => $type, 'errors' => $errors]);
    }

    public function get(Request $request) {
        $id = $request->route('id');
        $type = NotificationType::find($id);
        $errors = [];

        if($type === null)
            $errors[] = ['code' => "404", 'message' => "type with ID <{$id}> does not exist"];

        if(!empty($errors))
            return response()->json(['data' => null, 'errors' => $errors])->setStatusCode(404);

        $include = explode(',', $request->input('include'));
        if(in_array('notifications', $include)) {
            $type->notifications;
        }
        if(in_array('subscribes', $include)) {
            $type->subscribes;
        }

        return response()->json(['data' => $type, 'errors' => $errors]);
    }

    public function delete(Request $request) {
        $id = $request->route('id');
        $type = NotificationType::find($id);
        $errors = [];

        if($type === null)
            $type->delete();

        return response()->json(['data' => null, 'errors' => $errors]);
    }
}
