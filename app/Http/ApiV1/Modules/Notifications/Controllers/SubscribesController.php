<?php

namespace App\Http\ApiV1\Modules\Notifications\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\Notifications\Models\Subscribe;


class SubscribesController
{
    public function add(Request $request) {
        $courseId = $request->request->get('user_id');

        $notification = Subscribe::create([
            'user_id' => $courseId
        ]);

        return response()->json(['id' => $notification->id]);
    }

    public function get(Request $request) {
        $id = $request->route('id');

        $subscribe = Subscribe::find($id);

        return response()->json(['data' => $subscribe]);
    }

    public function delete(Request $request) {
        $id = $request->route('id');

        Subscribe::find($id)->delete();

        return response()->json(['data' => 'success']);
    }
}
