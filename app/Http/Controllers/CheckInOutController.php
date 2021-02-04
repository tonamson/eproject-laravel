<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CheckInOutController extends Controller
{
    public function index()
    {
        return view('main.check_in_out.index');
    }

    public function create(Request $request)
    {
        $check_in_date = date('Y-m-d');
        $check_in_at = date('Y-m-d H:i:s');
        $latitude = $request->input('latitude1');
        $longitude = $request->input('longitude1');

        if(empty($latitude) || empty($longitude)) {
            return redirect()->back()->with('error', 'Vui lòng bật GPS theo hướng dẫn!');
        }

        //Converting to radians
        // 590 cmt8
        // $lati1 = deg2rad('10.7863823'); 
        // $longi1 = deg2rad('106.6641083');
        $lati1 = deg2rad('10.778933'); 
        $longi1 = deg2rad('106.6880956');
        $lati2 = deg2rad($latitude); 
        $longi2 = deg2rad($longitude); 

        //Haversine Formula 
        $difflong = $longi2 - $longi1; 
        $difflat = $lati2 - $lati1; 
    
        $val = pow(sin($difflat/2),2)+cos($lati1)*cos($lati2)*pow(sin($difflong/2),2); 
    
        $res2 = 6378.8 * (2 * asin(sqrt($val))); //for kilomet

        if($res2 > 0.5) {
            return redirect()->back()->with('error', 'Bạn cách xa văn phòng quá 500m!');
        }

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

    public function show(Request $request)
    {
        $user = auth()->user();

        $month = $request->input('month');
        $year = $request->input('year');
        if(!$month) {
            $month = date("m");
        }
        if(!$year) {
            $year = date("Y");
        }
        $date = $year . '-' . $month . '-' . '01';
        $data_request = ['staff_id' => $user->id, 'y_m' => $date];

        $response = Http::post('http://localhost:8888/check-in-out/get-staff-time', $data_request);
        $body = json_decode($response->body(), true);

        return view('main.check_in_out.staff_time')
            ->with('data', $body['data'])
            ->with('year', $year)
            ->with('month', $month);
    }
}
