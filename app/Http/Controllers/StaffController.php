<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class StaffController extends Controller
{
    public function index(){

        $response = Http::get('http://localhost:8888/department/list', []);
        $body = json_decode($response->body(), true);
        $dsPhongBan = [];
        if($body['isSuccess']){
            $dsPhongBan=$body['data'];
        }
        $response = Http::get('http://localhost:8888/staff/list');
        $body = json_decode($response->body(), true);
        $data_staff = $body['data'];

        return view('main.staff.index',[
            'data_staff' => $data_staff,
            'data_department' => $dsPhongBan,
        ]);
        
    }

    public function createStaff(Request $request)
    {
        $code = $request->input('txtCode');
        $firstname = $request->input('txtFname');
        $lastname = $request->input('txtLname');
        $department = $request->input('txtDepartment');
        $isManager = $request->input('txtisManager');
        $joinedAt = $request->input('txtJoinat');
        $dob = $request->input('txtDob');
        $gender = $request->input('txtGender');
        $regional = $request->input('txtRegional');
        $phoneNumber = $request->input('txtPhone');
        $email = $request->input('txtEmail');
        $password = $request->input('txtPass');

       $idNumber = $request->input('txtIDNumber');
        $photo = $request->input('txtPhoto');
        $idPhoto = $request->input('txtIDPhoto');
        $idPhotoBack = $request->input('txtIDPhoto2');
        $note = $request->input('txtNote');
      //  $dayOfLeave =request(0);


        $data_request = [
            'code' => $code,
            'firstname' =>$firstname,
            'lastname' =>$lastname,
            'department' =>$department,
            'isManager'=>$isManager,
            'joinedAt' =>$joinedAt,
            'dob'=>$dob,
            'gender'=>$gender,
            'regional' =>$regional,
            'phoneNumber' =>$phoneNumber,
            'email' =>$email,
            'password' => bcrypt($password),

           'idNumber' =>$idNumber,
            'photo' =>$photo,
            'idPhoto' =>$idPhoto,
            'idPhotoBack' =>$idPhotoBack,
            "dayOfLeave"=>0,
            'note' =>$note,
          //  'createdAt' =>$createdAt::now(),
            "status" =>$status=0,
      
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

        $response = Http::get('http://localhost:8888/department/list', []);
        $body = json_decode($response->body(), true);
        $dsPhongBan = [];
        if($body['isSuccess']){
            $dsPhongBan=$body['data'];
        }

        $response = Http::get('http://localhost:8888/regional/list',[]);
        $body = json_decode($response->body(), true);
        $dsKhuvuc = [];
        if($body['isSuccess']){
            $dsKhuvuc=$body['data'];
        }

        return view('main.staff.add',[
            'data_reg' => $dsKhuvuc,
            'data_department' => $dsPhongBan,
        ]);
        return view('main.staff.add');
    }
}
