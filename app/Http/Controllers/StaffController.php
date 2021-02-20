<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class StaffController extends Controller
{
    public function index(){

        $response = Http::get('http://localhost:8888/staff/list');
        $body = json_decode($response->body(), true);
        $data_staff = $body['data'];

        return view('main.staff.index')
        ->with('data_staff', $data_staff);
    
    }
}
