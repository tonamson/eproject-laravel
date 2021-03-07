<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CheckInOutController extends Controller
{
    public function index()
    {
        $params = [
            'id' => auth()->user()->id,
        ];
        $response = Http::get('http://localhost:8888/staff/findOneStaffDepartment', $params);
        $body = json_decode($response->body(), true);

        return view('main.check_in_out.index')
                ->with('staff', $body['data'])
                ->with('breadcrumbs', [['text' => 'Công phép', 'url' => '../view-menu/time-leave'], ['text' => 'Chấm công GPS', 'url' => '#']]);
    }

    public function create(Request $request)
    {
        $user = auth()->user();
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
            "staff_id" => $user->id,
            'staff_code' => $user->code,
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

        return response($body);
    }

    public function show(Request $request)
    {
        $user = auth()->user();

        $params = [
            'id' => auth()->user()->id,
        ];
        $response_staff = Http::get('http://localhost:8888/staff/findOneStaffDepartment', $params);
        $body_staff = json_decode($response_staff->body(), true);

        $month = $request->input('month');
        $year = $request->input('year');
        if(!$month) {
            $month = date("m");
        }
        if(!$year) {
            $year = date("Y");
        }
        $date_special = $year . '-' . $month . '-' . '01';
        $data_request_special = ['special_date_from' => $date_special];

        $response_special = Http::get('http://localhost:8888/special-date/list?', $data_request_special);
        $body_special = json_decode($response_special->body(), true);
        
        $date = $year . '-' . $month . '-' . '01';
        $data_request = ['staff_id' => $user->id, 'y_m' => $date];

        $response = Http::post('http://localhost:8888/check-in-out/get-staff-time', $data_request);
        $body = json_decode($response->body(), true);

        $calendar = array();
        foreach ($body_special['data'] as $value) {
            $arr = array();
            $arr['title'] = $value['note'];
            $arr['start'] = $value['daySpecialFrom'];
            $arr['end'] = date("Y-m-d", strtotime('+1 days', strtotime($value['daySpecialTo'])));
            if($value['typeDay'] == 1) {
                $arr['color'] = '#EF5350';
            } else {
                $arr['color'] = '#046A38';
            }

            array_push($calendar, $arr);
        }

        foreach ($body['data'] as $value) {
            $arr = array();
            $title = 'Giờ vào: ' . $value['check_in'] . ', Giờ ra: ' . $value['check_out'];

            $arr['title'] = $title;
            $arr['start'] = $value['check_in_day_no_format'];

            if($value['multiply'] == 2) {
                $arr['color'] = '#1e551e';
            } else if($value['multiply'] == 3) {
                $arr['color'] = '#755c16';
            }

            array_push($calendar, $arr);
        }

        return view('main.check_in_out.staff_time')
            ->with('data', $body['data'])
            ->with('year', $year)
            ->with('month', $month)
            ->with('staff', $body_staff['data'])
            ->with('calendar', json_encode($calendar))
            ->with('breadcrumbs', [['text' => 'Công phép', 'url' => '../view-menu/time-leave'], ['text' => 'Lịch sử chấm công', 'url' => '#']]);
    }
}
