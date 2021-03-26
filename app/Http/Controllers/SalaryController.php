<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class SalaryController extends Controller
{

    public function getIndex(Request $request)
    {
        $response = Http::get(config('app.api_url') . '/salary/list', [
            'del' => boolval($request->del)
        ]);
        $body = json_decode($response->body(), false);
        $data = [];
        if ($body->isSuccess) {
            $data = $body->data;
        }
        return view('main.salary.index', [
            'data' => $data
        ]);
    }

    public function getDetail(Request $request)
    {
        $response = Http::get(config('app.api_url') . '/salary/details', [
            'id' => $request->id
        ]);
        $body = json_decode($response->body(), false);
        $data = [];
        if ($body->isSuccess) {
            $data = $body->data;
        }

        if (count($data) > 0) {
            return view('main.salary.details', [
                'data' => $data,
            ]);
        }

        return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Không tìm thấy ID']);
    }

    public function getCreate()
    {
        $response = Http::get(config('app.api_url') . '/staff/list', []);
        $listStaffResponse = json_decode($response->body(), false);
        $responseSalaryOption = Http::get(config('app.api_url') . '/salary-option/list', []);
        $listSalaryOptionResponse = json_decode($responseSalaryOption->body(), false);
        $listStaff = [];
        $listSalaryOption = [];
        if ($listStaffResponse->isSuccess) {
            $listStaff = $listStaffResponse->data;
        }
        if ($listSalaryOptionResponse->isSuccess) {
            $listSalaryOption = $listSalaryOptionResponse->data;
        }

        return view('main.salary.create', [
            'listStaff' => $listStaff,
            'listSalaryOption' => $listSalaryOption,
        ]);
    }

    public function postCalculatedSalary(Request $request)
    {
        // tài liệu https://laravel.com/docs/8.x/validation#available-validation-rules
        $rule = [
            'from_date' => 'required|date_format:Y-m-d',
            'to_date' => 'required|date_format:Y-m-d',
        ];
        $message = [
            'from_date.required' => 'Ngày bắt đầu không để rỗng',
            'from_date.date_format' => 'Ngày bắt đầu sai định dạng: YYYY-MM-DD',
            'to_date.required' => 'Ngày kết thúc không để rỗng',
            'to_date.date_format' => 'Ngày kết thúc sai định dạng: YYYY-MM-DD',
        ];
        $data = $request->all();
        $data['staffs'] = array_values($data['staffs']);
        return response()->json($data);

        $validate = Validator::make($data, $rule, $message);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }

        $response = Http::post(config('app.api_url') . '/salary/calculated', $data);
        $body = json_decode($response->body(), false);
        if ($body->isSuccess) {
            return redirect()->back()->with('message', [
                'type' => 'success',
                'message' => 'Tính lương hoàn tất.'
            ]);
        }

        return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Tính lương thất bại: ' . $body->message]);
    }

    public function getDeleteSalary($id)
    {
        $response = Http::get(config('app.api_url') . '/salary/detail', [
            'id' => $id
        ]);
        $body = json_decode($response->body(), false);
        $salary = null;
        if ($body->isSuccess) {
            $salary = $body->data;
        }
        if ($salary) {
            if ($salary->status == 'pending') {
                $response = Http::get(config('app.api_url') . '/salary/delete', [
                    'id' => $id
                ]);
                $body = json_decode($response->body(), false);
                if ($body->isSuccess) {
                    return redirect()->back()->with('message', ['type' => 'success', 'message' => 'Xóa thành công']);
                } else {
                    return redirect()->back()->with('message', ['type' => 'danger', 'message' => $body->message]);
                }
            } else {
                return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Chỉ có thể xóa bảng tính chưa khóa']);
            }
        }
        return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Không tìm thấy bảng tính lương']);
    }

    public function getChangeStatusSuccessSalary($id)
    {
        $response = Http::get(config('app.api_url') . '/salary/detail', [
            'id' => $id
        ]);
        $body = json_decode($response->body(), false);
        $salary = null;
        if ($body->isSuccess) {
            $salary = $body->data;
        }
        if ($salary) {
            if ($salary->status == 'pending') {
                $response = Http::post(config('app.api_url') . '/salary/update-status', [
                    'id' => $id,
                    'status' => 'success',
                ]);
                $body = json_decode($response->body(), false);
                if ($body->isSuccess) {
                    return redirect()->back()->with('message', ['type' => 'success', 'message' => $body->message]);
                } else {
                    return redirect()->back()->with('message', ['type' => 'danger', 'message' => $body->message]);
                }
            } else {
                return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Chỉ có thể chuyển bảng tính chưa khóa']);
            }
        }
        return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Không tìm thấy bảng tính lương']);
    }
}
