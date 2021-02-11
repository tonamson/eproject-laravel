<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TimeleaveController extends Controller
{
    public function index(Request $request)
    {
        $params_get_department = [
            'id' => auth()->user()->id,
        ];
        $response_get_department = Http::get('http://localhost:8888/staff/findOneStaffDepartment', $params_get_department);
        $body_get_department = json_decode($response_get_department->body(), true);

        $user = auth()->user();

        $month = $request->input('month');
        $year = $request->input('year');
        if(!$month) {
            $month = date("m");
        }
        if(!$year) {
            $year = date("Y");
        }

        $date = $year . '-' . $month . '-' . '01';
        $data_request = ['staff_id' => $user->id, 'day_time_leave' => $date];

        $response = Http::post('http://localhost:8888/time-leave/list', $data_request);
        $body = json_decode($response->body(), true);
        //dd($body['data']);

        return view('main.time_leave.index')
            ->with('data', $body['data'])
            ->with('year', $year)
            ->with('month', $month)
            ->with('staff', $body_get_department['data']);
    }

    public function createTime(Request $request)
    {
        $user = auth()->user();

        $day_leave = $request->input('day_leave');
        $number_day_leave = $request->input('number_day_leave');
        $note_bsc = $request->input('note_bsc');

        if($number_day_leave == 1)
            $time = "08:00:00";
        else
            $time = "04:00:00";
        
        $data_request = [
            "staff_id" => $user->id,
            'staff_code' => $user->code,
            'day_time_leave' => $day_leave,
            'time' => $time,
            'type' => false,
            'note' => $note_bsc,
        ];

        $response = Http::post('http://localhost:8888/time-leave/add', $data_request);
        $body = json_decode($response->body(), true);

        if($body['message'] == "Save success") {
            return redirect()->back()->with('success', 'Bổ sung công thành công! Vui lòng đợi quản lý phê duyệt');
        } 
        else if($body['data'] == "Added time") {
            return redirect()->back()->with('error', 'Bổ sung công thất bại! Bạn đã đi làm và chấm công ngày ' . $day_leave . ' rồi! Vui lòng chỉnh sửa');
        }
        else {
            return redirect()->back()->with('error', 'Bổ sung công thất bại! Bạn đã bổ sung công / đăng kí phép ngày ' . $day_leave . ' rồi! Vui lòng chỉnh sửa');
        }
    }

    public function deleteTime(Request $request)
    {
        $id = $request->input('id');
        
        $data_request = [
            "id" => $id
        ];

        Http::post('http://localhost:8888/time-leave/delete', $data_request);

        return redirect()->back()->with('success', 'Xóa thành công!');
    }

    public function detailTime(Request $request)
    {
        $id = $request->input('id');
        
        $data_request = [
            "id" => $id
        ];

        $response = Http::get('http://localhost:8888/time-leave/detail', $data_request);
        $body = json_decode($response->body(), true);

        if($body['data']['time'] == '08:00:00') {
            $option = '
                <option value="1" selected>Một ngày</option>
                <option value="0.5">Nửa ngày</option>
            ';
        } else {
            $option = '
                <option value="1">Một ngày</option>
                <option value="0.5" selected>Nửa ngày</option>
            ';
        }
        

        $html = "<input type='hidden' name='id_update' value='". $id ."'>";
        $html.= '<div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">Bổ Sung Công</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $html.= '<span aria-hidden="true">&times;</span></button></div>';
        $html.= '
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Ngày bổ sung:</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control day_leave_update" name="day_leave_update" value="'.$body['data']['dayTimeLeave'].'" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Yêu cầu điều chỉnh:</label>
                    <div class="col-lg-9">
                        <select class="form-control" name="number_day_leave_update" id="number_day_leave_update" required>
                            '.$option.'
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Lý do:</label>
                    <div class="col-lg-9">
                        <textarea class="form-control" name="note_bsc_update" id="note_bsc_update" cols="20" rows="10" placeholder="VD: Quên check in, Quên check out, ..." required>'.$body['data']['note'].'</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Thay đổi</button>
            </div>

            <script>
                $(".day_leave_update").daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: "YYYY-MM-DD"
                    }
                });
            </script>
        ';
       
        echo $html;
        die;
    }

    public function updateTime(Request $request)
    {
        $user = auth()->user();

        $id_update = $day_leave = $request->input('id_update');
        $day_leave = $request->input('day_leave_update');
        $number_day_leave = $request->input('number_day_leave_update');
        $note_bsc = $request->input('note_bsc_update');

        if($number_day_leave == 1)
            $time = "08:00:00";
        else
            $time = "04:00:00";
        
        $data_request = [
            "id" => $id_update,
            "staff_id" => $user->id,
            'day_time_leave' => $day_leave,
            'time' => $time,
            'note' => $note_bsc,
        ];

        $response = Http::post('http://localhost:8888/time-leave/update', $data_request);
        $body = json_decode($response->body(), true);

        if($body['message'] == "Update success") {
            return redirect()->back()->with('success', 'Chỉnh sửa thành công! Vui lòng đợi quản lý phê duyệt');
        } 
        else if($body['data'] == "Added time") {
            return redirect()->back()->with('error', 'Bổ sung công / Đăng kí phép thất bại! Bạn đã đi làm và chấm công ngày ' . $day_leave . ' rồi! Vui lòng chỉnh sửa');
        }
        else {
            return redirect()->back()->with('error', 'Chỉnh sửa thất bại! Bạn đã Bổ sung công / Đăng kí phép ngày ' . $day_leave . ' rồi!');
        }
    }

    //Phep
    public function createLeave(Request $request)
    {
        $user = auth()->user();

        if($user->day_of_leave == 0) {
            return redirect()->back()->with('error', 'Bạn đã hết ngày phép');
        }

        $day_leave = $request->input('day_leave');
        $number_day_leave = $request->input('number_day_leave');
        $note_dkp = $request->input('note_dkp');

        if($number_day_leave == 1)
            $time = "08:00:00";
        else
            $time = "04:00:00";
        
        $data_request = [
            "staff_id" => $user->id,
            'staff_code' => $user->code,
            'day_time_leave' => $day_leave,
            'time' => $time,
            'type' => true,
            'note' => $note_dkp,
        ];

        $response = Http::post('http://localhost:8888/time-leave/addLeave', $data_request);
        $body = json_decode($response->body(), true);

        if($body['message'] == "Save success") {
            return redirect()->back()->with('success', 'Đăng kí phép thành công! Vui lòng đợi quản lý phê duyệt');
        } 
        else if($body['data'] == "Added time") {
            return redirect()->back()->with('error', 'Đăng kí phép thất bại! Bạn đã đi làm và chấm công ngày ' . $day_leave . ' rồi! Vui lòng chỉnh sửa');
        }
        else {
            return redirect()->back()->with('error', 'Đăng kí phép thất bại! Bạn đã Đăng kí phép / Bổ sung công ngày ' . $day_leave . ' rồi! Vui lòng chỉnh sửa');
        }
    }

    public function detailLeave(Request $request)
    {
        $id = $request->input('id');
        
        $data_request = [
            "id" => $id
        ];

        $response = Http::get('http://localhost:8888/time-leave/detail', $data_request);
        $body = json_decode($response->body(), true);

        if($body['data']['time'] == '08:00:00') {
            $option = '
                <option value="1" selected>Một ngày</option>
                <option value="0.5">Nửa ngày</option>
            ';
        } else {
            $option = '
                <option value="1">Một ngày</option>
                <option value="0.5" selected>Nửa ngày</option>
            ';
        }
        

        $html = "<input type='hidden' name='id_update' value='". $id ."'>";
        $html.= '<div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">Đăng Kí Phép</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $html.= '<span aria-hidden="true">&times;</span></button></div>';
        $html.= '
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Ngày đăng kí phép:</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control day_leave_update" name="day_leave_update" value="'.$body['data']['dayTimeLeave'].'" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Yêu cầu phép:</label>
                    <div class="col-lg-9">
                        <select class="form-control" name="number_day_leave_update" id="number_day_leave_update" required>
                            '.$option.'
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Lý do:</label>
                    <div class="col-lg-9">
                        <textarea class="form-control" name="note_bsc_update" id="note_bsc_update" cols="20" rows="10" placeholder="VD: Bận việc gia đình, Đi học, ..." required>'.$body['data']['note'].'</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Thay đổi</button>
            </div>

            <script>
                $(".day_leave_update").daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: "YYYY-MM-DD"
                    }
                });
            </script>
        ';
       
        echo $html;
        die;
    }
}
