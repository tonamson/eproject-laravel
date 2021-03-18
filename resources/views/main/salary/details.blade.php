@extends('main._layouts.master')

@section('css')
@endsection

@section('js')
    <script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/anytime.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable_init.js') }}"></script>
@endsection

@section('js')
@endsection


@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Chi tiết bảng tính lương</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @php
                        $total_salary = 0;
                    @endphp
                    @foreach($data as $item)
                        @if($total_salary += $item->salary) @endif
                    @endforeach
                    <h3>Tổng chi lương: <b class="text-success">{{ number_format($total_salary) }} VND</b></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table datatable-basic">
                        <thead>
                        <tr>
                            <th>Mã nhân viên</th>
                            <th>Tên nhân viên</th>
                            <th>Tổng công</th>
                            <th>Lương cơ bản</th>
                            <th>Lương tăng ca</th>
                            <th>Các khoản phụ cấp</th>
                            <th>Các khoản khấu trừ</th>
                            <th>
                                <p>Thu nhập chịu thuế</p>
                                <p>= Tổng lương - Các khoản được miễn</p>
                            </th>
                            <th>
                                <p>Thu nhập tính thuế</p>
                                <p>= Thu nhập chịu thuế - Các khoản được trừ (BHXH và các khoản giảm trừ gia cảnh)</p>
                            </th>
                            <th>
                                <p>Lương thực nhận</p>
                                <p>= Tổng lương + phụ cấp - Các khoản khấu trừ - Thuế TNCN</p>
                            </th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td>{{ $item->staff->id }}</td>
                                <td>{{ $item->staff->firstname . ' '. $item->staff->lastname }}</td>
                                <td>
                                    @php
                                        $total_working_of_day = 0;
                                        if(isset($item->details)) {
                                            foreach($item->details as $detail){
                                                $total_working_of_day += $detail->total_working_of_day;
                                            }
                                        }
                                    @endphp
                                    {{ number_format($total_working_of_day) }}
                                </td>
                                <td>{{ number_format($item->salary) }}</td> <!-- lương cơ bản -->
                                <td>{{ number_format($item->salaryOt) }}</td> <!-- lương tăng ca -->
                                <td>{{ number_format($item->salary) }}</td>
                                <td>{{ number_format($item->salary) }}</td>
                                <td>{{ number_format($item->salary) }}</td>
                                <td>{{ number_format($item->salary) }}</td>
                                <td>{{ number_format($item->salary) }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalDetail" onclick="loadDetailStaff({{ $item->staff->id }})">Chi tiết</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!-- Full width modal -->
                    <div id="modalDetail" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Chi tiết bảng lương</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <table class="table datatable-detail">
                                        <thead>
                                        <tr>
                                            <th>Mã nhân viên</th>
                                            <th>Tên nhân viên</th>
                                            <th>Ngày chấm công</th>
                                            <th>Công chuẩn của tháng</th>
                                            <th>Lương hợp đồng</th>
                                            <th>Hệ số</th>
                                            <th>Lương 1 ngày</th>
                                            <th>Công đã làm</th>
                                            <th>Thành tiền lương ngày công</th>
                                            <th>Lương 1 giờ</th>
                                            <th>Tổng giờ tăng ca</th>
                                            <th>Thành tiền lương tăng ca</th>
                                            <th>Lương tăng ca chịu thuế</th>
                                            <th>Tổng lương</th>
                                        </tr>
                                        </thead>
                                        <tbody id="dataDetail"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /full width modal -->

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/picker_date_init.js') }}"></script>
    <script>
        let json_data = {!! json_encode($data) !!};
        Number.prototype.format = function (n, x) {
            var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
            return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
        };

        function loadDetailStaff(id) {
            let dataTable = $('.datatable-detail').DataTable();
            $('#dataDetail').html('');
            dataTable.clear().draw();
            json_data.forEach(item => {
                if (item.staffId === id && item.details != null && item.details.length > 0) {
                    item.details.forEach(detail => {
                        dataTable.row.add([
                            `${detail.contract.staff.code}`,
                            `${detail.contract.staff.firstname + ' ' + detail.contract.staff.lastname}`,
                            `${detail.day_detail}`,
                            `${detail.standard_days}`,
                            `${detail.contract.salary.format()}`,
                            `${detail.multiply_day.format()}`,
                            `${detail.salary_per_day.format()}`,
                            `${detail.total_working_of_day}`,
                            `${detail.salary_of_day.format()}`,
                            `${detail.salary_by_one_hour.format()}`,
                            `${detail.ot_hours}`,
                            `${detail.salary_of_ot.format()}`,
                            `${detail.salary_of_ot_tax.format()}`,
                            `${detail.total_salary.format()}`,
                        ]).draw(false);
                    });
                    return;
                }
            });
        }
    </script>
@endsection
