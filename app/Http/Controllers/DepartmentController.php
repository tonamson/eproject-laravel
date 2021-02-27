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

    public function listUndo(){

        $response = Http::get('http://localhost:8888/department/listUndo');
        $body = json_decode($response->body(), true);
        $data_department = $body['data'];

        return view('main.department.listUndo')
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

    public function add() {
        return view('main.department.add');
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

    public function getEditDep(Request $request) {
        $data_request = $request->all();

        $response = Http::get('http://localhost:8888/department/detail', $data_request);
        $body = json_decode($response->body(), true);
        //dd($body);
        if($body['isSuccess']){
            return view('main/department/edit', [
                'data' => $body['data']
            ]);

            
        }
        return redirect()->back()->with('message','Khong tim thay phong ban');
    }

    public function postEditDep(Request $request) {
        // $data_request = $request->all();

        $id =$request->input('txtID');
        $name = $request->input('txtName');
        $nameVn = $request->input('txtName1');
        $del =$request->input('txtDel');
        
        $data_request = [
            'id'=>$id,
            'name' => $name,
            'nameVn' =>$nameVn,
            'del'=>$del,
        ];
        
        $response = Http::post('http://localhost:8888/department/update', $data_request);
        
        $body = json_decode($response->body(), true);
        
        if( $body['isSuccess'] == "Update success"){
            return redirect()->back()->with('message', 'Cập nhật thành công!');
        }
        return redirect()->back()->with('message','Cập nhật thất bại');
    }


    public function deleteDepartment(Request $request) {
        // $data_request = $request->all();

        $id =$request;
        $name = $request;
        $nameVn = $request;
       // $del =$request->input('txtDel');
        
        $data_request = [
            'id'=>$id,
            'name' => $name,
            'nameVn' =>$nameVn,
            'del'=>$del ==0,
        ];
        
        $response = Http::post('http://localhost:8888/department/update', $data_request);
        
        $body = json_decode($response->body(), true);
        
        if( $body['isSuccess'] == "Update success"){
            return redirect()->back()->with('message', 'Xóa thành công!');
        }
        return redirect()->back()->with('message','Xóa thất bại');
    }


    // public function deleteDepartment(Request $request)
    // {
    //     $id = $request->input('id');
        
    //     $data_request = [
    //         "id" => $id
    //     ];

    //     Http::post('http://localhost:8888/department/delete', $data_request);

    //     return redirect()->back()->with('success', 'Xóa thành công!');
    // }
   
}
