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
            <table class="table datatable-basic">
                <thead>
                <tr>
                    <th>Mã nhân viên</th>
                    <th>Tên nhân viên</th>
                    <th>Tổng công</th>
                    <th>Lương</th>
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
                                    <th>Lương</th>
                                    <th>Lương 1 ngày</th>
                                    <th>Công đã làm</th>
                                    <th>Hệ số</th>
                                    <th>Tổng tiền</th>
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
            json_data.forEach(item => {
                if (item.staffId === id && item.details != null && item.details.length > 0) {
                    item.details.forEach(detail => {
                        dataTable.row.add([
                            `${detail.contract.staff.code}`,
                            `${detail.contract.staff.firstname + ' ' + detail.contract.staff.lastname}`,
                            `${detail.day_detail}`,
                            `${detail.standard_days}`,
                            `${detail.contract.salary.format()}`,
                            `${detail.salary_per_day.format()}`,
                            `${detail.total_working_of_day}`,
                            `${detail.multiply_day.format()}`,
                            `${detail.salary_of_day.format()}`
                        ]).draw(false);
                    });
                    return;
                }
            });
        }
    </script>
@endsection
