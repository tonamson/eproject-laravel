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
        ->with('data_department', $data_department);
    
    }

    public function delete(){
        $id = $request->input('id');
        
        $data_request = [
            "id" => $id
        ];

        Http::post('http://localhost:8888/department/delete', $data_request);
        return redirect()->back()->with('success', 'Xóa thành công!');

        
    }

    public function createDepartment(Request $request)
    {
        $name = $request->input('txtName');
        $nameVn = $request->input('txtName1');
        
        $data_request = [
            'name' => $name,
            'nameVn' =>$nameVn,
        ];

        $response = Http::post('http://localhost:8888/department/add', $data_request);
        $body = json_decode($response->body(), true);

        if($body['message'] == "Save success") {
            return redirect()->back()->with('success', 'Thêm thành công!');
        } 
        else {
            return redirect()->back()->with('error', 'Thêm thất bại');
        }
    }

    public function add() {
        return view('main.department.add');
    }
    
    


   
}
