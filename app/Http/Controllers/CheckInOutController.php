<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CheckInOutController extends Controller
{
    public function index()
    {
        $date     = date('Y-m-d');
        $to_day   = date('d/m/Y');

        return view('main.check_in_out.index', [
            'message' => 'Hello World',
        ]);
    }

    public function create(Request $request)
    {
        $check_in_date = date('Y-m-d');
        $check_in_at = date('Y-m-d H:i:s');
        $latitude = $request->input('latitude1');
        $longitude = $request->input('longitude1');

        $body = [
            "staff_id" => '2',
            'staff_code' => 'Code',
            'check_in_day' => $check_in_date,
            'check_in_at' => $check_in_at
        ];

        $response = Http::post('http://localhost:8888/check-in-out/create', $body);
        $body = json_decode($response->body(), true);

        if($body['message'] == "Save success") {
            return redirect()->back()->with('success', 'Chấm công thành công!');   
        } else {
            return redirect()->back()->with('error', 'Chấm công thất bại!');   
        }

        var_dump($body['message']);
        return response($body);
    }

}
