<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    public function getList(Request $request)
    {
        $response = Http::get(config('app.api_url') . '/contract/list', [
            'del' => boolval($request->del)
        ]);
        $body = json_decode($response->body(), false);
        $data = [];
        if ($body->isSuccess) {
            $data = $body->data ?? [];
        }
        return view('main.contract.index', [
            'data' => $data,
            'breadcrumbs' => [
                ['text' => 'Hợp đồng', 'url' => '../view-menu/contract'], ['text' => 'Danh sách hợp đồng', 'url' => '#']
            ]
        ]);
    }

    public function getDetail($id)
    {
        $response = Http::get(config('app.api_url') . '/staff/list', []);
        $listStaff = json_decode($response->body(), false);

        $response = Http::get(config('app.api_url') . '/contract/detail', ['id' => $id]);
        $editContractResponse = json_decode($response->body(), false);
        $contract = null;
        if ($editContractResponse->isSuccess) {
            $contract = $editContractResponse->data;
        }
        return view('main.contract.detail', [
            'listStaff' => $listStaff->data,
            'contract' => $contract,
            'breadcrumbs' => [
                ['text' => 'Hợp đồng', 'url' => '../view-menu/contract'], ['text' => 'Chỉnh sửa hợp đồng', 'url' => '#']
            ]
        ]);
    }

    public function getCreate()
    {
        $response = Http::get(config('app.api_url') . '/staff/list', []);
        $listStaff = json_decode($response->body(), false);
        return view('main.contract.create', [
            'listStaff' => $listStaff->data,
            'breadcrumbs' => [
                ['text' => 'Hợp đồng', 'url' => '../view-menu/contract'], ['text' => 'Tạo mới hợp đồng', 'url' => '#']
            ]
        ]);
    }

    public function postSave(Request $request)
    {
        $rule = [
            'staffId' => 'required',
            'startDate' => 'required|date_format:Y-m-d',
            'endDate' => 'required|date_format:Y-m-d|after_or_equal:startDate',
            'salary' => 'required|numeric',
            'details' => 'required|array',
            'details.*.name' => 'required',
            'details.*price' => 'required|numeric',
        ];
        $message = [
            'staffId.required' => 'Mã nhân viên không để rỗng',
            'startDate.required' => 'Ngày bắt đầu không để rỗng',
            'endDate.required' => 'Ngày kết thúc không để rỗng',
            'startDate.date_format' => 'Ngày bắt đầu sai định dạng: YYYY-MM-DD',
            'endDate.date_format' => 'Ngày kết thúc sai định dạng: YYYY-MM-DD',
            'endDate.after_or_equal' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu',
            'salary.required' => 'Tổng lương không để rỗng',
            'salary.numeric' => 'Tổng lương chỉ chấp nhận số',
            'details.required' => 'Chi tiết hợp đồng không để rỗng',
            'details.array' => 'Chi tiết hợp đồng chỉ chấp nhận mảng',
            'details.*.name.required' => 'Tên chi tiết không để rỗng',
            'details.*.price.required' => 'Giá không để rỗng',
        ];
        $data = $request->all();
        $validate = Validator::make($data, $rule, $message);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }
        $data['stopDate'] = $data['endDate']; // set cho stopDate bằng enddate lúc save

        $response = Http::post(config('app.api_url') . '/contract/save', $data);
        $body = json_decode($response->body(), false);;
        if ($body->isSuccess) {
            return redirect()->back()->with('message', [
                'type' => 'success',
                'message' => 'Lưu hợp đồng thành công.'
            ]);
        }
        return redirect()->back()->with('message', ['type' => 'danger', 'message' => $body->message]);
    }

    public function stopContract($id)
    {
        $response = Http::get(config('app.api_url') . '/contract/stop', ['id' => $id]);
        $editContractResponse = json_decode($response->body(), false);
        $contract = null;
        if ($editContractResponse->isSuccess) {
            $contract = $editContractResponse->data;
        }
        if (!$contract) {
            return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Không tìm thấy hợp đồng']);
        }
        return redirect()->back()->with('message', ['type' => 'success', 'message' => 'Chấm dứt hợp đồng thành công']);
    }

    public function getDelete($id)
    {
        $response = Http::get(config('app.api_url') . '/contract/delete', ['id' => $id]);
        $body = json_decode($response->body(), false);
        if ($body->isSuccess) {
            return redirect()->back()->with('message', ['type' => 'success', 'message' => 'Xóa hợp đồng thành công.']);
        }
        return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Xóa hợp đồng thất bại.']);
    }
}
