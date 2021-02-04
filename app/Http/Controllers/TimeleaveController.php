<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TimeleaveController extends Controller
{
    public function createTime(Request $request)
    {
        $user = auth()->user();

        $day_leave = $request->input('day_leave');
        $number_day_leave = $request->input('number_day_leave');
        $note_bsc = $request->input('note_bsc');

        if($number_day_leave == 1)
            $time = "08:00:00";
        else
            $time = "04:00:00";
        
        $data_request = [
            "staff_id" => $user->id,
            'staff_code' => $user->code,
            'day_time_leave' => $day_leave,
            'time' => $time,
            'type' => false,
            'note' => $note_bsc,
        ];

        $response = Http::post('http://localhost:8888/time-leave/add', $data_request);
        $body = json_decode($response->body(), true);

        if($body['message'] == "Save success") {
            return redirect()->back()->with('success', 'Bổ sung công thành công! Vui lòng đợi quản lý phê duyệt');
        } else {
            return redirect()->back()->with('error', 'Bổ sung công thất bại!');
        }
    }
}
