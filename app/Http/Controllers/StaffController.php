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
        $photo = $request->file('txtPhoto');
        $idPhoto = $request->file('txtIDPhoto');
        $idPhotoBack = $request->file('txtIDPhoto2');
        $note = $request->input('txtNote');
        $user = auth()->user();
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
            "dayOfLeave"==0,
            'note' =>$note,
            "createdBy" => $user->id,
            "status" =>$status=0,
      
        ];
        $response = Http::attach('attachment', file_get_contents($photo), 'photo.jpg')
            ->post('http://localhost:8888/staff/add', $data_request);
       // dd($response);
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

        $response = Http::get('http://localhost:8888/regional/list-district',['parent' => 3410]);
        $body = json_decode($response->body(), true);
        $district_default = [];
        if($body['isSuccess']){
            $district_default=$body['data'];
        }

        return view('main.staff.add',[
            'data_reg' => $dsKhuvuc,
            'data_department' => $dsPhongBan,
            'data_district' => $district_default,
        ]);
        return view('main.staff.add');
    }

    // Get & Post Update Staff

    public function getDetail(Request $request) {
        $data_request = $request->all();

        $response = Http::get('http://localhost:8888/staff/one', $data_request);
        $body = json_decode($response->body(), true);
        //dd($body);
        if($body['isSuccess']){
            return view('main/staff/detail', [
                'data' => $body['data']
            ]);

            
        }
        return redirect()->back()->with('message','Khong tim nhan vien');
    }

    public function getEditStaff(Request $request) {
      
        //chinh
        $data_request = $request->all();

        $response = Http::get('http://localhost:8888/staff/one', $data_request);
        $body = json_decode($response->body(), true);
        if($body['isSuccess']){
            $staff=$body['data'];
        }

        $response = Http::get('http://localhost:8888/regional/get-one',['id' => $staff['regional']]);
        $body = json_decode($response->body(), true);
        $district_default = [];
        if($body['isSuccess']){
            $district_selected=$body['data'];
        }

        $response = Http::get('http://localhost:8888/regional/list',[]);
        $body = json_decode($response->body(), true);
        $dsKhuvuc = [];
        if($body['isSuccess']){
            $dsKhuvuc=$body['data'];
        }

        $response = Http::get('http://localhost:8888/regional/list-district',['parent' => $district_selected['parent']]);
        $body = json_decode($response->body(), true);
        $district_default = [];
        if($body['isSuccess']){
            $district_default=$body['data'];
        }

        $response = Http::get('http://localhost:8888/department/list', []);
        $body = json_decode($response->body(), true);
        $dsPhongBan = [];
        if($body['isSuccess']){
            $dsPhongBan=$body['data'];
        }


        if($body['isSuccess']){
            return view('main/staff/edit', [
                'data' => $staff,
                'data_department' => $dsPhongBan,
                'data_reg' => $dsKhuvuc,
                'data_district' => $district_default,
                'district_selected' => $district_selected
            ]);
        }
        return redirect()->back()->with('message','Khong tim nhan vien');
    }


    public function postEditStaff(Request $request) {

        $id =$request->input('txtID');
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
        
        $data_request = [
            'id'=>$id,
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
            "dayOfLeave"==0,
            'note' =>$note,
            "status" =>$status=0,
        ];
       
        $response = Http::post('http://localhost:8888/staff/update', $data_request);
       // dd($response);
        $body = json_decode($response->body(), true);
        
        if( $body['isSuccess'] == "Update success"){
            return redirect()->back()->with('message', 'Cập nhật thành công!');
        }
        return redirect()->back()->with('message','Cập nhật thất bại');
    }

    public function viewProfile(Request $request) {
        $params = [
            'staff_id' => auth()->user()->id,
        ];
        $response = Http::get('http://localhost:8888/staff/get-profile', $params);
        $body = json_decode($response->body(), true);

        $response_edu = Http::get('http://localhost:8888/education/get-education-by-staff-id', $params);
        $body_edu = json_decode($response_edu->body(), true);

        $response_contract = Http::get('http://localhost:8888/contract/by-staff', $params);
        $body_contract = json_decode($response_contract->body(), true);

        //dd($body_contract['data']);

        return view('main.staff.view_profile', [
            'staff' => $body['data'],
            'educations' => $body_edu['data'],
            'contracts' => $body_contract['data']
        ]);
    }

    public function loadRegional(Request $request) {
        $parent =$request->input('parent');

        $params = [
            'parent' => $parent
        ];

        $response = Http::get('http://localhost:8888/regional/list-district', $params);
        $body = json_decode($response->body(), true);

        echo json_encode($body['data']);
        exit;
    }

    public function listUndo(){

        $response = Http::get('http://localhost:8888/department/list', []);
        $body = json_decode($response->body(), true);
        $dsPhongBan = [];
        if($body['isSuccess']){
            $dsPhongBan=$body['data'];
        }
        $response = Http::get('http://localhost:8888/staff/listUndo');
        $body = json_decode($response->body(), true);
        $data_staff = $body['data'];

        return view('main.staff.listUndo',[
            'data_staff' => $data_staff,
            'data_department' => $dsPhongBan,
        ]);
        
    }

    public function getDeleteStaff(Request $request)
    {
        $id = $request->id;
        $response = Http::get(config('app.api_url') . '/staff/delete', ['id' => $id]);
        $body = json_decode($response->body(), false);
     
        if ($body->isSuccess) {
            return redirect()->back()->with('message', ['type' => 'success', 'message' => 'Xóa nhân viên thành công.']);
        }
        return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Xóa nhân viên thất bại.']);
    }

    public function getUndoStaff(Request $request)
    {
        $id = $request->id;
        $response = Http::get(config('app.api_url') . '/staff/undo', ['id' => $id]);
        $body = json_decode($response->body(), false);
        if ($body->isSuccess) {
            return redirect()->back()->with('message', ['type' => 'success', 'message' => 'Khôi phục nhân viên thành công.']);
        }
        return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Khôi phục nhân viên thất bại.']);
    }
   

}
