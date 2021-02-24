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

    public function createStaff(Request $request)
    {
        $code = $request->input('txtCode');
        $firstname = $request->input('txtFname');
        $lastname = $request->input('txtLname');
        
        $data_request = [
            'code' => $code,
            'firstname' =>$firstname,
            'lastname' =>$lastname,
        ];

        $response = Http::post('http://localhost:8888/staff/add', $data_request);
        $body = json_decode($response->body(), true);

        if($body['message'] == "Save success") {
            return redirect()->back()->with('success', 'Thêm thành công!');
        } 
        else {
            return redirect()->back()->with('error', 'Thêm thất bại');
        }
    }

    public function vaddStaff() {
        return view('main.staff.add');
    }
}
