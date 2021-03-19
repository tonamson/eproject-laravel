<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TransferController extends Controller
{

    public function list(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        if(!$month) {
            $month = date("m");
        }
        if(!$year) {
            $year = date("Y");
        }

        $date = $year . '-' . $month . '-' . '01';
        $data_request = ['day_get' => $date, 'department' => auth()->user()->department];

        $response = Http::get('http://localhost:8888/transfer/list', $data_request);
        $body = json_decode($response->body(), true);
    //  dd($body);

        $response = Http::get(config('app.api_url') . '/staff/list', []);
        $listStaff = json_decode($response->body(), false);

    
        $response = Http::get('http://localhost:8888/department/list');
        $body_department = json_decode($response->body(), true);
        $data_department = $body_department['data'];

        return view('main.transfer.list', [
            'listStaff' => $listStaff->data,
            'listDepartment' => $data_department,
            'year' => $year,
            'month' => $month,
            'data' => $body['data'] ?? [],
            'breadcrumbs' => [['text' => 'Điều chuyển', 'url' => '../view-menu/transfer']]
        ]);
    }

    public function loadOldDepartment(Request $request) {
        $id = $request->input('old_department');

        $data_request = ['id' => $id];

        $response = Http::get('http://localhost:8888/department/detail', $data_request);
        $department_old = json_decode($response->body(), true);
        $department_old_name = $department_old['data']['name'];

        $html = "<option value='$id' selected>$department_old_name</option>";

        echo $html;die;
    }

    public function create(Request $request)
    {
        $id_staff_transfer = $request->input('staff_id');
        $id_staff_create = $request->input('id_staff_create');
        $old_department = $request->input('old_department');
        $new_department = $request->input('new_department');
        $note = $request->input('note');      

        if(!$id_staff_transfer) {
            return redirect()->back()->with('error', 'Vui lòng chọn nhân viên điều chuyển!');
        }

        if($old_department == $new_department) {
            return redirect()->back()->with('error', 'Phòng ban hiện tại và phòng ban điều chuyển phải khác nhau!');
        }

        if(strlen($note) > 300) {
            return redirect()->back()->with('error', 'Ghi chú không được vượt quá 300 kí tự');
        }

        $data_check = [
            'staff_id' => $id_staff_transfer
        ];

        $response_check = Http::post('http://localhost:8888/transfer/check', $data_check);
        $body_check = json_decode($response_check->body(), true);

        if($body_check['data']) {
            return redirect()->back()->with('error', 'Tạo điều chuyển thất bại! Nhân viên này đang trong trạng thái điều chuyển');
        }
        
        $data_request = [
            'staff_id' => $id_staff_transfer,
            'new_department' => $new_department,
            'created_by' => $id_staff_create,
            'oldManagerApproved'=>"0",
            'newManagerApproved'=>"0",
            'managerApproved'=>"0",
            'del'=>"0",
            'note' => $note,
            'created_at' => date('Y-m-d')
        ];

        $response = Http::post('http://localhost:8888/transfer/create', $data_request);
        $body = json_decode($response->body(), true);

       
        if($body['message'] == "Save success") {
            return redirect()->back()->with('success', 'Tạo điều chuyển thành công!');
        } 
        else {
            return redirect()->back()->with('error', 'Tạo điều chuyển thất bại!');
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        
        $data_request = [
            "id" => $id
        ];

        Http::post('http://localhost:8888/transfer/delete', $data_request);

        return redirect()->back()->with('success', 'Xóa thành công!');
    }

    public function detail(Request $request)
    {
        $id = $request->input('id');
        
        $data_request = [
            "id" => $id
        ];

        $response = Http::get('http://localhost:8888/transfer/detail', $data_request);
        $body = json_decode($response->body(), true);

        $data_request_staff = [
            "id" => $body['data']['staffId']
        ];

        $response_staff = Http::get('http://localhost:8888/staff/one', $data_request_staff);
        $body_staff = json_decode($response_staff->body(), true);

        $data_request_old_department = ['id' => $body_staff['data']['department']];

        $response_old_department = Http::get('http://localhost:8888/department/detail', $data_request_old_department);
        $department_old = json_decode($response_old_department->body(), true);
        $department_old_name = $department_old['data']['name'];

        $response = Http::get(config('app.api_url') . '/staff/list', []);
        $listStaff = json_decode($response->body(), false);

        $response = Http::get('http://localhost:8888/department/list');
        $body_department = json_decode($response->body(), true);
        $data_department = $body_department['data'];

        $html_list_staff = '';
        foreach ($listStaff->data as $staff) {
            if($body['data']['staffId'] == $staff->id) {
                $html_list_staff .= '<option value="'.$staff->id.'" selected>'.$staff->firstname .' '. $staff->lastname.'</option>';
            }
        }

        $html_list_department = '';
        foreach ($data_department as $department) {
            if($body['data']['newDepartment'] == $department['id']) {
                $html_list_department .= '<option value="'.$department['id'].'" selected>'.$department['name'].'</option>';
            } else {
                $html_list_department .= '<option value="'.$department['id'].'">'.$department['name'].'</option>';
            }
        }

        $html = '<input type="hidden" name="id_update" value="'.$id.'">';
        $html.= '
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Tạo Điều Chuyển Mới</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Tên nhân viên</label>
                <div class="col-lg-9">
                    <select class="form-control select-search select_staff_transfer" name="staff_id_update"  id="selected_staff" readonly="true">
                        '.$html_list_staff.'
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Phòng ban hiện tại:</label>
                <div class="col-lg-9">
                    <select class="form-control old_department" name="old_department_update" readonly="true">
                        <option value="'.$id.'">'.$department_old_name.'</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Phòng ban điều chuyển:</label>
                <div class="col-lg-9">
                    <select class="form-control new_department" name="new_department_update">
                        '.$html_list_department.'
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Ghi chú:</label>
                <div class="col-lg-9">
                    <textarea class="form-control" name="note_update" id="note" cols="20" rows="10" placeholder="VD: Quản lý yêu cầu, ..." required>'.$body['data']['note'].'</textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary">Sửa</button>
        </div>
        ';
       
        echo $html;
        die;
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $id_update = $request->input('id_update');
        $old_department = $request->input('old_department_update');
        $new_department = $request->input('new_department_update');
        $note = $request->input('note_update');

        if($old_department == $new_department) {
            return redirect()->back()->with('error', 'Phòng ban hiện tại và phòng ban điều chuyển phải khác nhau!');
        }

        if(strlen($note) > 300) {
            return redirect()->back()->with('error', 'Ghi chú không được vượt quá 300 kí tự');
        }
        
        $data_request = [
            'id' => $id_update,
            'new_department' => $new_department,
            'note' => $note
        ];


        $response = Http::post('http://localhost:8888/transfer/update', $data_request);
        $body = json_decode($response->body(), true);

        if($body['message'] == "Update success") {
            return redirect()->back()->with('success', 'Chỉnh sửa điều chuyển thành công!');
        } 
        else {
            return redirect()->back()->with('error', 'Chỉnh sửa điều chuyển thất bại!');
        }
    }

    public function approve(Request $request) {
        $id = $request->input('id');
        $department = auth()->user()->department;

        $data_request = [
            'id' => $id,
            'department' => $department
        ];

        $response = Http::get('http://localhost:8888/transfer/approve', $data_request);
        $body = json_decode($response->body(), true);

        if($body['data'] == "Approve Success") {
            return redirect()->back()->with('success', 'Phê duyệt thành công, khi quản lý còn lại và Giám đốc phê duyệt, nhân viên sẽ chuyển phòng ban!');
        } else if($body['data'] == "Staff changed department") {
            return redirect()->back()->with('success', 'Phê duyệt thành công, nhân viên đã chuyển phòng ban!');
        } else {
            return redirect()->back()->with('error', 'Phê duyệt điều chuyển thất bại!');
        }
    }
}
