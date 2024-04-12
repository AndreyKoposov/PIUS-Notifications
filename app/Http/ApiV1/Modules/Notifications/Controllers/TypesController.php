<?php

namespace App\Http\ApiV1\Modules\Notifications\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\Notifications\Models\NotificationType;


class TypesController
{
    public function add(Request $request) {
        $courseId = $request->request->get('course_id');

        $type = NotificationType::create([
            'course_id' => $courseId
        ]);

        return response()->json(['id' => $type->id]);
    }

    public function get(Request $request) {
        $id = $request->route('id');

        $type = NotificationType::find($id);

        return response()->json(['data' => $type]);
    }

    public function delete(Request $request) {
        $id = $request->route('id');

        NotificationType::find($id)->delete();

        return response()->json(['data' => 'success']);
    }
}