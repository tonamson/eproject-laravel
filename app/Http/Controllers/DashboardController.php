<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class DashboardController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:8888/staff/list');
        $body = json_decode($response->body(), true);
        $data_staffs = $body['data'];

        $response_count = Http::get('http://localhost:8888/staff/getStaffMonth');
        $body_staffs_count = json_decode($response_count->body(), true);
        $data_staffs_count = $body_staffs_count['data'];

        $response_count_off = Http::get('http://localhost:8888/staff/getStaffOffDateMonth');
        $body_staffs_off_count = json_decode($response_count_off->body(), true);
        $data_staffs_off_count = $body_staffs_off_count['data'];

        $date=date_create("2013-03-15");
        $now = getdate();

        //Chart Genders
        $staffs_gender = array();
        $count_male = 0;
        $count_female = 0;

        //Chart age
        $staffs_age = array();
        $age_18_to_25 = 0;
        $age_25_to_35 = 0;
        $age_35_to_45 = 0;
        $age_45_to_55 = 0;
        $age_other = 0;

        foreach ($data_staffs as $key => $value) {
            if($value['gender'] == 1)
                $count_male++;
            if($value['gender'] == 2)
                $count_female++;

            $date = date_create($value['dob']);
            $yob = date_format($date,"Y");
            $age = $now['year'] - $yob;

            switch ($age) {
                case $age <= 25:
                    $age_18_to_25++;
                    break;
                case $age <= 35:
                    $age_25_to_35++;
                    break;
                case $age <= 45:
                    $age_35_to_45++;
                    break;
                case $age <= 55:
                    $age_45_to_55++;
                    break;
                default:
                    $age_other++;
                    break;
            }
        }

        $staffs_gender['Nam'] = $count_male;
        $staffs_gender['Nu'] = $count_female;
        $staffs_gender = json_encode($staffs_gender);

        $staffs_age['18_to_25'] = $age_18_to_25;
        $staffs_age['25_to_35'] = $age_25_to_35;
        $staffs_age['35_to_45'] = $age_35_to_45;
        $staffs_age['45_to_55'] = $age_45_to_55;
        $staffs_age['age_other'] = $age_other;
        $staffs_age = json_encode($staffs_age);

        //Chart Totals Staff By Month
        $arr_chart_staffs_month = array();
        foreach ($data_staffs_count[0] as $key => $value) {
            array_push($arr_chart_staffs_month, $value);
        }
        $staffs_month = json_encode($arr_chart_staffs_month);
        $last_year = date("Y",strtotime("-1 year"));

        //Chart Totals Staff By Month
        $arr_chart_staffs_off = array();
        foreach ($data_staffs_off_count[0] as $key => $value) {
            array_push($arr_chart_staffs_off, $value);
        }
        $staffs_off = json_encode($arr_chart_staffs_off);

        
        return view('main.dashboard.index')
            ->with('staffs_gender', $staffs_gender)
            ->with('staffs_age', $staffs_age)
            ->with('staffs_month', $staffs_month)
            ->with('last_year', $last_year)
            ->with('staffs_off', $staffs_off);
    }
}
