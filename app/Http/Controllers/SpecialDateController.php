<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class SpecialDateController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year');
        $month = date("m");
        if(!$year) {
            $year = date("Y");
        }

        $date = $year . '-' . $month . '-' . '01';
        $data_request = ['special_date_from' => $date];

        $response = Http::get('http://localhost:8888/special-date/list?', $data_request);
        $body = json_decode($response->body(), true);

        $calendar = array();
        foreach ($body['data'] as $value) {
            if($value['typeDay'] == 1) {
                $arr = array();
                $arr['title'] = $value['note'];
                $arr['start'] = $value['daySpecialFrom'];
                $arr['end'] = date("Y-m-d", strtotime('+1 days', strtotime($value['daySpecialTo'])));
                $arr['color'] = '#EF5350';

                array_push($calendar, $arr);
            }
        }

        return view('main.special_date.index')
            ->with('data', $body['data'])
            ->with('year', $year)
            ->with('calendar', json_encode($calendar))
            ->with('breadcrumbs', [['text' => 'Công phép', 'url' => '../view-menu/time-leave'], ['text' => 'Quản lý ngày lễ', 'url' => '#']]);
    }

    public function createSpecialDate(Request $request)
    {
        $day_special_from = $request->input('day_special_from');
        $day_special_to = $request->input('day_special_to');
        $note = $request->input('note');
        $type_day = $request->input('type_day');
        
        $date = date("Y-m-d");
        $data_request = ['special_date_from' => $date, 'staff_request' => auth()->user()->id, 'department_request' => auth()->user()->department];

        $response_check = Http::get('http://localhost:8888/special-date/get-request-ot?', $data_request);
        $body_check = json_decode($response_check->body(), true);
        
        if($day_special_from < date('Y-m-d')) {
            return redirect()->back()->with('error', 'Ngày bắt đầu không được nhỏ hơn ngày hiện tại! Vui lòng thử lại');
        }

        foreach ($body_check['data'] as $value) {
            if($value['type_day'] == 2 && $value['department_request'] == auth()->user()->department) {
                if(($value['day_special_from'] >= $day_special_from && $value['day_special_from'] <= $day_special_to) || ($value['day_special_to'] >= $day_special_from && $value['day_special_to'] <= $day_special_to)) {
                    return redirect()->back()->with('error', 'Ngày tăng ca không được chồng chéo nhau!');
                }
            }

            if($value['type_day'] == 1) {
                if(($value['day_special_from'] >= $day_special_from && $value['day_special_from'] <= $day_special_to) || ($value['day_special_to'] >= $day_special_from && $value['day_special_to'] <= $day_special_to)) {
                    if($type_day == 1)
                        return redirect()->back()->with('error', 'Ngày lễ không được chồng chéo nhau!');
                    else 
                        return redirect()->back()->with('error', 'Ngày tăng ca không được chồng chéo ngày lễ!');
                }
            }
        }

        if($day_special_from > $day_special_to) {
            return redirect()->back()->with('error', 'Từ ngày không được nhỏ hơn đến ngày! Vui lòng thử lại');
        }

        if(strlen($note) > 300) {
            return redirect()->back()->with('error', 'Mô tả không được vượt quá 300 kí tự');
        }
        
        $data_request = [
            'day_special_from' => $day_special_from,
            'day_special_to' => $day_special_to,
            'note' => $note,
            'type_day' => $type_day
        ];

        if($type_day == 2) {
            $data_request['staff_request'] = auth()->user()->id;
            $data_request['department_request'] = auth()->user()->department;
            $data_request['is_approved'] = 0;
        }

        $response = Http::post('http://localhost:8888/special-date/add', $data_request);
        $body = json_decode($response->body(), true);

        if($body['message'] == "Save SpecialDate success") {
            if($type_day == 1)
                return redirect()->back()->with('success', 'Thêm ngày lễ thành công!');
            else
                return redirect()->back()->with('success', 'Đề xuất tăng ca thành công! Vui lòng chờ giám đốc duyệt');
        } 
        else {
            if($type_day == 1)
                return redirect()->back()->with('error', 'Thêm ngày lễ thất bại!');
            else
                return redirect()->back()->with('error', 'Đề xuất tăng ca thất bại!');
        }
    }

    public function deleteSpecialDate(Request $request)
    {
        $id = $request->input('id');
        
        $data_request = [
            "id" => $id
        ];

        Http::post('http://localhost:8888/special-date/delete', $data_request);

        return redirect()->back()->with('success', 'Xóa thành công!');
    }

    public function detailSpecialDate(Request $request)
    {
        $id = $request->input('id');
        
        $data_request = [
            "id" => $id
        ];

        $response = Http::get('http://localhost:8888/special-date/detail', $data_request);
        $body = json_decode($response->body(), true);

        $title = "Lễ";

        if($body['data']['typeDay'] == 2) {
            $title = "Tăng Ca";
        }        

        $html = "<input type='hidden' name='id_update' value='". $id ."'>";
        $html.= '<div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">Chỉnh Sửa Ngày '.$title.'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $html.= '<span aria-hidden="true">&times;</span></button></div>';
        $html.= '
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Từ ngày:</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control day_leave" name="day_special_from" value="'.$body['data']['daySpecialFrom'].'" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Đến ngày:</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control day_leave" name="day_special_to" value="'.$body['data']['daySpecialTo'].'" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Mô tả ngày '.$title.':</label>
                    <div class="col-lg-9">
                        <textarea class="form-control" name="note" id="note" cols="20" rows="10" placeholder="VD: Lễ quốc khánh, Lễ Tết, ..." required>'.$body['data']['note'].'</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Sửa</button>
            </div>

            <script>
                $(".day_leave").daterangepicker({
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

    public function updateSpecialDate(Request $request)
    {
        $user = auth()->user();

        $id_update = $request->input('id_update');
        $day_special_from = $request->input('day_special_from');
        $day_special_to = $request->input('day_special_to');
        $note = $request->input('note');

        $date = date("Y-m-d");
        $data_request = ['special_date_from' => $date, 'staff_request' => auth()->user()->id, 'department_request' => auth()->user()->department];

        $response_check = Http::get('http://localhost:8888/special-date/get-request-ot?', $data_request);
        $body_check = json_decode($response_check->body(), true);
        
        if($day_special_from < date('Y-m-d')) {
            return redirect()->back()->with('error', 'Ngày bắt đầu không được nhỏ hơn ngày hiện tại! Vui lòng thử lại');
        }

        foreach ($body_check['data'] as $value) {
            if($id_update == $value['id']) {
                continue;
            }
            
            if($value['type_day'] == 2 && $value['department_request'] == auth()->user()->department) {
                if(($value['day_special_from'] >= $day_special_from && $value['day_special_from'] <= $day_special_to) || ($value['day_special_to'] >= $day_special_from && $value['day_special_to'] <= $day_special_to)) {
                    return redirect()->back()->with('error', 'Ngày tăng ca không được chồng chéo nhau!');
                }
            }
            if($value['type_day'] == 1) {
                if(($value['day_special_from'] >= $day_special_from && $value['day_special_from'] <= $day_special_to) || ($value['day_special_to'] >= $day_special_from && $value['day_special_to'] <= $day_special_to)) {
                    return redirect()->back()->with('error', 'Ngày tăng ca và ngày lễ không được chồng chéo nhau!');
                }
            }
        }

        if($day_special_from > $day_special_to) {
            return redirect()->back()->with('error', 'Từ ngày không được nhỏ hơn đến ngày! Vui lòng thử lại');
        }

        if(strlen($note) > 300) {
            return redirect()->back()->with('error', 'Mô tả ngày lễ không được vượt quá 300 kí tự');
        }
        
        $data_request = [
            "id" => $id_update,
            'day_special_from' => $day_special_from,
            'day_special_to' => $day_special_to,
            'note' => $note,
        ];

        $response = Http::post('http://localhost:8888/special-date/update', $data_request);
        $body = json_decode($response->body(), true);

        if($body['message'] == "Update Special Date success") {
            return redirect()->back()->with('success', 'Chỉnh sửa ngày lễ thành công!');
        } 
        else {
            return redirect()->back()->with('error', 'Chỉnh sửa ngày lễ thất bại!');
        }
    }

    public function requestOverTime(Request $request) {
        $params_get_department = [
            'id' => auth()->user()->id,
        ];
        $response_get_department = Http::get('http://localhost:8888/staff/findOneStaffDepartment', $params_get_department);
        $body_get_department = json_decode($response_get_department->body(), true);

        $year = $request->input('year');
        $month = date("m");
        if(!$year) {
            $year = date("Y");
        }

        $date = $year . '-' . $month . '-' . '01';
        $data_request = ['special_date_from' => $date, 'staff_request' => auth()->user()->id, 'department_request' => auth()->user()->department];

        $response = Http::get('http://localhost:8888/special-date/get-request-ot?', $data_request);
        $body = json_decode($response->body(), true);

        $calendar = array();
        foreach ($body['data'] as $value) {
            if($value['is_approved'] == 1 or $value['type_day'] == 1) {
                $arr = array();
                if($value['type_day'] == 1) {
                    $arr['title'] = $value['note'];
                } else {
                    $arr['title'] = $value['name_department_request'] . " - " . $value['note'];
                }
                $arr['start'] = $value['day_special_from'];
                $arr['end'] = date("Y-m-d", strtotime('+1 days', strtotime($value['day_special_to'])));
                if($value['type_day'] == 1) {
                    $arr['color'] = '#EF5350';
                } else {
                    $arr['color'] = '#046A38';
                }
    
                array_push($calendar, $arr);
            }
        }

        return view('main.special_date.request_ot')
            ->with('data', $body['data'])
            ->with('year', $year)
            ->with('calendar', json_encode($calendar))
            ->with('staff', $body_get_department['data'])
            ->with('breadcrumbs', [['text' => 'Công phép', 'url' => '../view-menu/time-leave'], ['text' => 'Tăng ca', 'url' => '#']]);
    }

    public function detailOverTime(Request $request)
    {
        $id = $request->input('id');
        
        $data_request = [
            "id" => $id
        ];

        $response = Http::get('http://localhost:8888/special-date/detail-ot?', $data_request);
        $body = json_decode($response->body(), true);

        $title = "Lễ";

        if($body['data']['type_day'] == 2) {
            $title = "Tăng Ca";
        }     
        
        $html = "<input type='hidden' name='id_update' value='". $id ."'>";
        $html.= '<div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">Chi Tiết Đề Xuất '.$title.'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $html.= '<span aria-hidden="true">&times;</span></button></div>';
        $html.= '
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nhân viên đề xuất:</label>
                    <div class="col-lg-9">
                        <label class="col-form-label">'.$body['data']['full_name_staff_request'].'</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Mã nhân viên:</label>
                    <div class="col-lg-9">
                        <label class="col-form-label">'.$body['data']['code'].'</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Phòng ban đề xuất:</label>
                    <div class="col-lg-9">
                        <label class="col-form-label">'.$body['data']['name_department_request'].'</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Từ ngày:</label>
                    <div class="col-lg-9">
                        <label class="col-form-label">'.$body['data']['day_special_from'].'</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Đến ngày:</label>
                    <div class="col-lg-9">
                        <label class="col-form-label">'.$body['data']['day_special_to'].'</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Mô tả ngày '.$title.':</label>
                    <div class="col-lg-9">
                        <textarea class="form-control" name="note" id="note" cols="15" rows="7" placeholder="VD: Lễ quốc khánh, Lễ Tết, ..." readonly>'.$body['data']['note'].'</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="btn_approve" value="1" class="btn btn-success">Duyệt</button>
                <button type="submit" name="btn_reject" value="-1" class="btn btn-danger">Từ chối</button>
            </div>

            <script>
                $(".day_leave").daterangepicker({
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

    public function approveOverTime(Request $request) {
        $id_update = $request->input('id_update');
        $approve = $request->input('btn_approve');
        $reject = $request->input('btn_reject');
        $is_approve = $approve ? $approve : $reject;

        $data_request = [
            "id" => $id_update,
            'is_approved' => $is_approve,
        ];

        $response = Http::post('http://localhost:8888/special-date/approve-ot', $data_request);
        $body = json_decode($response->body(), true);

        if($body['message'] == "Approve success") {
            return redirect()->back()->with('success', 'Thành công!');
        } 
        else {
            return redirect()->back()->with('error', 'Thất bại!');
        }
    }
}
