@extends('main._layouts.master')

<?php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
?>

@section('css')
    <link href="{{ asset('assets/css/components_datatables.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('js')    
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/notifications/jgrowl.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/picker_date.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable_init.js') }}"></script>
@endsection

@section('content')
    <!-- Basic datatable -->
    <div class="card">
        <h1 class="pt-3 pl-3 pr-3">Lưới Công</h1>
        <div class="card-body">
            @if (\Session::has('success'))
                <div class="">
                    <div class="alert alert-success">
                        {!! \Session::get('success') !!}
                    </div>
                </div>
            @endif

            @if (\Session::has('error'))
                <div class="">
                    <div class="alert alert-danger">
                        {!! \Session::get('error') !!}
                    </div>
                </div>
            @endif
            <form action="{{ action('TimeleaveController@getAllStaffTime') }}" method="GET">
                @csrf
                <div class="form-group d-flex">
                    <div class="">
                        <select class="form-control" name="month" id="month">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" <?php echo $month == $i ? 'selected' : ''?>>Tháng {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="ml-2">
                        <input class="form-control" type="number" value="<?php echo $year ?>" name="year" id="year">
                    </div>
                    <div class="ml-3">
                        <input class="form-control btn btn-primary" type="submit" value="Search">
                    </div>
                </div>
            </form>
        </div>

        <table class="table datatable-basic">
            <thead>
                <tr>
                    <td>Mã nhân viên</td>
                    <td>Họ tên</td>
                    <td>Phòng ban</td>
                    <td>Chức vụ</td>
                    <th>Ngày</th>
                    <th>Thứ</th>
                    <th class="text-center">Giờ vào</th>
                    <th class="text-center">Giờ ra</th>
                    <th>Đi Trễ</th>
                    <th>Về Sớm</th>
                    <th>Công</th>
                    <th>Tổng giờ</th>
                    <th>Tăng ca</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $check_in_out)
                    <tr style="
                        <?php 
                            if($check_in_out['special_date_id'] !== null) echo "background-color: #ffe7e7";
                            else if($check_in_out['day_of_week'] == 1 or $check_in_out['day_of_week'] == 7)  echo "background-color: #d3ffd4";
                        ?>
                    ">
                        <td>{{ $check_in_out['code'] }}</td>
                        <td>{{ $check_in_out['full_name'] }}</td>
                        <td>{{ $check_in_out['department_name'] }}</td>
                        <td>{{ $check_in_out['is_manager'] == 1 ? "Quản lý" : "Nhân viên" }}</td>
                        <td>{{ $check_in_out['check_in_day'] }}</td>
                        <td>
                            <?php 
                                if($check_in_out['day_of_week'] == 1) {
                                    echo 'Chủ Nhật';
                                } else {
                                    echo 'Thứ ' . $check_in_out['day_of_week'];
                                }
                            ?>
                            <?php 
                                if($check_in_out['special_date_id'] !== null) {
                                    echo '(Ngày lễ)';
                                }
                            ?>
                        </td>
                        <td class="text-center" style="max-width: 100px;">
                            {{ $check_in_out['check_in'] }}
                            <img src="../images/check_in/{{ $check_in_out['image_check_in'] }}" width="80px" alt="">
                        </td>
                        <td class="text-center" style="max-width: 100px;">
                            {{ $check_in_out['check_out'] }}
                            <img src="../images/check_in/{{ $check_in_out['image_check_out'] }}" width="80px" alt="">
                        </td>
                        <td>{{ $check_in_out['in_late'] }}</td>
                        <td>{{ $check_in_out['out_soon'] }}</td>
                        <td>{{ $check_in_out['number_time'] * $check_in_out['multiply'] }}</td>
                        <td>{{ $check_in_out['time'] }}</td>
                        <td>{{ $check_in_out['ot'] }}</td>
                    </tr>
                @endforeach       
            </tbody>
        </table>
    </div>
    <!-- /basic datatable -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#register_leave').click(function(){
                var request = new Request('http://localhost:8888/staff/updateDayOfLeave');

                fetch(request, {mode: 'no-cors'}).then(function(response) {
                    return response.json();
                }).then(function(j) {
                    console.log(JSON.stringify(j));
                }).catch(function(error) {
                    console.log('Request failed', error)
                });
            });
        });

    </script>
@endsection