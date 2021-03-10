<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DepartmentController extends Controller
{
    public function index(){

        $response = Http::get('http://localhost:8888/department/list');
        $body = json_decode($response->body(), true);
        $data_department = $body['data'];

        return view('main.department.index')
        ->with('data_department', $data_department)
        ->with('breadcrumbs', [['text' => 'Phòng ban', 'url' => '../view-menu/department'], ['text' => 'Danh sách phòng ban', 'url' => '#']]);
    }

    public function listUndo(){

        $response = Http::get('http://localhost:8888/department/listUndo');
        $body = json_decode($response->body(), true);
        $data_department = $body['data'];

        return view('main.department.listUndo')
        ->with('data_department', $data_department)
        ->with('breadcrumbs', [['text' => 'Phòng ban', 'url' => '../view-menu/department'], ['text' => 'Phòng ban đã xóa', 'url' => '#']]);
    }

    public function delete(Request $request){
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
        $rule = [
            'txtName' => 'required',
            'txtName1' => 'required',
        ];
        $message = [
            'txtName.required' => 'Tên Phòng Ban không để rỗng',
           
            'txtName1.required' => 'Tên Tiếng Việt không để rỗng',
           
        ];
        $data = $request->all();
        $validate = Validator::make($data, $rule, $message);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }

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
                'data' => $body['data'],
                'breadcrumbs' => [['text' => 'Phòng ban', 'url' => '../view-menu/department'], ['text' => 'Danh sách phòng ban', 'url' => '../deparment/index'], ['text' => 'Cập nhật phòng ban', 'url' => '#']]
            ]);

            
        }
        return redirect()->back()->with('message','Khong tim thay phong ban');
    }

    public function postEditDep(Request $request) {
        // $data_request = $request->all();
        $rule = [
            'txtName' => 'bail|required|min:3|max:50',
            'txtName1' => 'bail|required',
        ];
        $message = [
            'txtName.required' => 'Tên Phòng Ban không để rỗng',
            // 'txtName.unique' => 'Tên Phòng Ban đã tồn tại',
            'txtName.max' => 'Tên Phòng Ban tối đa 20 ký tự',
            'txtName.min' => 'Tên Phòng Ban tối thiểu 3 ký tự',
            'txtName1.required' => 'Tên Phòng Ban Tiếng Việt không để rỗng',  
        ];
        $data = $request->all();
        $validate = Validator::make($data, $rule, $message);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput();
        }

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


    public function getDeleteDep(Request $request)
    {
        $id = $request->id;
        $response = Http::get(config('app.api_url') . '/department/delete', ['id' => $id]);
        $body = json_decode($response->body(), false);
      // dd($body);
        if ($body->isSuccess) {
            return redirect()->back()->with('message', ['type' => 'success', 'message' => 'Xóa Phòng ban thành công.']);
        }
        return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Xóa Phòng ban thất bại.']);
    }

    public function getUndoDep(Request $request)
    {
        $id = $request->id;
        $response = Http::get(config('app.api_url') . '/department/undo', ['id' => $id]);
        $body = json_decode($response->body(), false);
        if ($body->isSuccess) {
            return redirect()->back()->with('message', ['type' => 'success', 'message' => 'Khôi phục phòng ban thành công.']);
        }
        return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Khôi phục phòng ban thất bại.']);
    }
   
}
