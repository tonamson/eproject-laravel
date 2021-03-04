<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class EducationController extends Controller
{
   
    public function index(){
        
        $response = Http::get('http://localhost:8888/staff/list');
        $body = json_decode($response->body(), true);
        $data_staff = $body['data'];

        $response = Http::get('http://localhost:8888/education/list');
        $body = json_decode($response->body(), true);
        $data_education = $body['data'];

        return view('main.education.index',[
            'data_staff' => $data_staff,
            'data_education' => $data_education,
        ]);
    }

    public function addEducation() {
        $response = Http::get('http://localhost:8888/staff/list');
        $body = json_decode($response->body(), true);
        $data_staff = $body['data'];
        return view('main.education.add',[
            'data_staff' => $data_staff,
           
        ]);

    }

    public function createEducation(Request $request) {
       
        $staffId = $request->input('txtStaffID');
        $level = $request->input('txtLevel');
        $levelName = $request->input('txtLevelName');
        $school = $request->input('txtSchool');
        $fieldOfStudy = $request->input('txtFieldOfStudy');
        $graduatedYear = $request->input('txtGraduatedYear');
        $grade = $request->input('txtGrade');
        $modeOfStudy = $request->input('txtModeOf');
    
        $data_request = [
   
            'staffId' => $staffId,
            'level' =>$level,
            'levelName' =>$levelName,
            'school' =>$school,
            'fieldOfStudy'=>$fieldOfStudy,
            'graduatedYear' =>$graduatedYear,
            'grade'=>$grade,
            'modeOfStudy'=>$modeOfStudy,
        ];
       
        $response = Http::post('http://localhost:8888/education/add', $data_request);
       $body = json_decode($response->body(), true);
     //   dd($body);
       if( $body['isSuccess'] == "Update success"){
           return redirect()->back()->with('message', 'Thêm thành công!');
       }
       return redirect()->back()->with('message','Thêm thất bại');
   }
    //Update

    public function getEditEducation(Request $request) {
      
        $data_request = $request->all();
        $response = Http::get('http://localhost:8888/staff/list');
        $body = json_decode($response->body(), true);
        $data_staff = $body['data'];

        $response = Http::get('http://localhost:8888/education/one', $data_request);
        $body = json_decode($response->body(), true);
        //dd($body);
        if($body['isSuccess']){
            return view('main/education/edit', [
                'data' => $body['data'],
                'data_staff'=> $data_staff,
            ]);
        }
        return redirect()->back()->with('message','Khong tim thay phong ban');
    }

    public function postEditEducation(Request $request) {
        $id=$request->input('txtID');
        $staffId = $request->input('txtStaffID');
        $level = $request->input('txtLevel');
        $levelName = $request->input('txtLevelName');
        $school = $request->input('txtSchool');
        $fieldOfStudy = $request->input('txtFieldOfStudy');
        $graduatedYear = $request->input('txtGraduatedYear');
        $grade = $request->input('txtGrade');
        $modeOfStudy = $request->input('txtModeOf');
    
        $data_request = [
            'id'=>$id,
            'staffId' => $staffId,
            'level' =>$level,
            'levelName' =>$levelName,
            'school' =>$school,
            'fieldOfStudy'=>$fieldOfStudy,
            'graduatedYear' =>$graduatedYear,
            'grade'=>$grade,
            'modeOfStudy'=>$modeOfStudy,
        ];
       
        $response = Http::post('http://localhost:8888/education/update', $data_request);
       $body = json_decode($response->body(), true);
     //   dd($body);
       if( $body['isSuccess'] == "Update success"){
           return redirect()->back()->with('message', 'Cập nhật thành công!');
       }
       return redirect()->back()->with('message','Cập nhật thất bại');
   }
//Delete

    public function deleteEducation(Request $request)
    {
        $id = $request->input('id');
        
        $data_request = [
            "id" => $id
        ];

        Http::post('http://localhost:8888/education/delete', $data_request);

        return redirect()->back()->with('success', 'Xóa thành công!');
    }
}
