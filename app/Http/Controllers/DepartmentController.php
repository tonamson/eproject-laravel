<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    public function index(){

        $response = Http::get('http://localhost:8888/department/list');
        $body = json_decode($response->body(), true);
        $data_department = $body['data'];

        return view('main.department.index')
        ->with('data_departmen', $data_department);
    
    }

   
}
