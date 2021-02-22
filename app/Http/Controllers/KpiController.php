<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class KpiController extends Controller
{
    public function setKpi(Request $request)
    {
        return view('main.kpi.set_kpi');
    }

    public function findKpiStaff(Request $request)
    {
        $staff_id = $request->input('staff_id');
        $kpi_name = $request->input('kpi_name');
        
        $data_request = [
            "staff_id" => $staff_id,
            "kpi_name" => $kpi_name
        ];

        $response = Http::get('http://localhost:8888/kpi/find-kpi-staff', $data_request);
        $body = json_decode($response->body(), true);

        if($kpi_name == null) {
            $html = '';
        } else if($body['data'] !== null) {
            $html = '<div class="alert alert-info div_set_kpi">
                        <strong>Trạng thái:</strong>
                        <b class="status_kpi">Đã thiết lập</b>
                        <a href="../kpi/set-detail-kpi?kpi_id='.$body['data']['id'].'&staff_id='.$staff_id.'&kpi_name='.$kpi_name.'" class="go_set_kpi">Vào chỉnh sửa</a>
                    </div>';
        } else {
            $html = '<div class="alert alert-info div_set_kpi">
                        <strong>Trạng thái:</strong>
                        <b class="status_kpi">Chưa thiết lập</b>
                        <a href="../kpi/set-detail-kpi?staff_id='.$staff_id.'&kpi_name='.$kpi_name.'" class="go_set_kpi">Vào thiết lập</a>
                    </div>';
        }

        echo $html;die;
    }

    public function findKpiDepartment(Request $request)
    {
        $department_id = $request->input('department_id');
        $kpi_name = $request->input('kpi_name');
        $staff_manager = $request->input('staff_manager');
        
        $data_request = [
            "department_id" => $department_id,
            "kpi_name" => $kpi_name
        ];

        $response = Http::get('http://localhost:8888/kpi/find-kpi-department', $data_request);
        $body = json_decode($response->body(), true);

        if($kpi_name == null) {
            $html = '';
        } else if($body['data'] !== null && $staff_manager == 1) {
            $html = '<div class="alert alert-info div_set_kpi">
                        <strong>Trạng thái:</strong>
                        <b class="status_kpi">Đã thiết lập</b>
                        <a href="../kpi/set-detail-kpi?kpi_id='.$body['data']['id'].'&department_id='.$department_id.'&kpi_name='.$kpi_name.'" class="go_set_kpi">Vào chỉnh sửa</a>
                    </div>';
        } else if($staff_manager == 1) {
            $html = '<div class="alert alert-info div_set_kpi">
                        <strong>Trạng thái:</strong>
                        <b class="status_kpi">Chưa thiết lập</b>
                        <a href="../kpi/set-detail-kpi?department_id='.$department_id.'&kpi_name='.$kpi_name.'" class="go_set_kpi">Vào thiết lập</a>
                    </div>';
        } else if($body['data'] !== null) {
            $html = '<div class="alert alert-info div_set_kpi">
                        <strong>Trạng thái:</strong>
                        <b class="status_kpi">Đã thiết lập</b>
                        <a href="../kpi/set-detail-kpi?department_id='.$department_id.'&kpi_name='.$kpi_name.'" class="go_set_kpi">Vào xem</a>
                    </div>';
        } else {
            $html = '<div class="alert alert-info div_set_kpi">
                        <strong>Trạng thái:</strong>
                        <b class="status_kpi">Chưa thiết lập</b>
                    </div>';
        }

        echo $html;die;
    }

    public function setDetailKpi(Request $request)
    {
        $department_id = $request->input('department_id');
        $kpi_name = $request->input('kpi_name');
        $kpi_id = $request->input('kpi_id');
        $staff_id = $request->input('staff_id');

        return view('main.kpi.set_detail_kpi')
                ->with('department_id', $department_id)
                ->with('kpi_id', $kpi_id)
                ->with('kpi_name', $kpi_name)
                ->with('staff_id', $staff_id);
    }
}
