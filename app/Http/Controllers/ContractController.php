<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
            $data = $body->data;
        }
        return view('main.contract.index', [
            'data' => $data,
            'breadcrumbs' => [
                ['text' => 'Hợp đồng', 'url' => '../view-menu/contract'], ['text' => 'Danh sách hợp đồng', 'url' => '#']
            ]
        ]);
    }

    public function getEdit($id)
    {
        $response = Http::get(config('app.api_url') . '/staff/list', []);
        $listStaff = json_decode($response->body(), false);

        $response = Http::get(config('app.api_url') . '/contract/edit', ['id' => $id]);
        $editContractResponse = json_decode($response->body(), false);
        $contract = null;
        if ($editContractResponse->isSuccess) {
            $contract = $editContractResponse->data;
        }
        return view('main.contract.edit', [
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
        $data = $request->all();
//        $data['createAt'] = Carbon::now()->format('yyyy-mm-dd');
        $response = Http::post(config('app.api_url') . '/contract/save', $data);
        $body = json_decode($response->body(), false);;
        if ($body->isSuccess) {
            return redirect()->back()->with('message', [
                'type' => 'success',
                'message' => 'Lưu hợp đồng thành công.'
            ]);
        }
        return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Lưu hợp đồng thất bại.']);
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

    public function getUndo($id)
    {
        $response = Http::get(config('app.api_url') . '/contract/undo', ['id' => $id]);
        $body = json_decode($response->body(), false);
        if ($body->isSuccess) {
            return redirect()->back()->with('message', ['type' => 'success', 'message' => 'Khôi phục hợp đồng thành công.']);
        }
        return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'Khôi phục hợp đồng thất bại.']);
    }
}
