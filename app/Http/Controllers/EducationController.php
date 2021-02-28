<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class EducationController extends Controller
{
   
    public function index(){

        $response = Http::get('http://localhost:8888/education/list');
        $body = json_decode($response->body(), true);
        $data_education = $body['data'];

        return view('main.education.index')
        ->with('data_education', $data_education);
    }

    public function addEducation() {
        return view('main.education.add');
    }

    public function createEducation(Request $request)
    {
        $staffId = $request->input('txtID');
        $level = $request->input('txtLevel');
        $levelName = $request->input('txtLevelName');
        $school = $request->input('txtSchoool');
        $fieldOfStudy = $request->input('txtFileOfStudy');
        $graduatedYear = $request->input('txtYear');
        $grade = $request->input('txtGrade');
        $modeOfStudy = $request->input('txtMode');

        
        $data_request = [
            'staffId' => $staffId,
            'level' =>$level,
            'levelName' =>$levelName,
            'school' =>$school,
            'fieldOfStudy' =>$fieldOfStudy,
            'graduatedYear' =>$graduatedYear,
            'grade' =>$grade,
            'modeOfStudy' =>$modeOfStudy,

        ];
        $response = Http::post('http://localhost:8888/education/add', $data_request);
        $body = json_decode($response->body(), true);

        if($body['message'] == "Save success") {
            return redirect()->back()->with('success', 'Thêm thành công!');
        } 
        else {
            return redirect()->back()->with('error', 'Thêm thất bại');
        }
    }

   
   

}
