@extends('main._layouts.master')

<?php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
?>

@section('css')
    <link href="{{ asset('assets/css/components_datatables.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        #tb_dkp_wrapper {
            display: none;
        }
    </style>
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
        @if(auth()->user()->department == 2 && auth()->user()->is_manager == 1)
            <h1 class="pt-3 pl-3 pr-3">Duyệt Công Phép</h1>
        @elseif(auth()->user()->department == 2)
            <h1 class="pt-3 pl-3 pr-3">Xem Công Phép</h1>
        @else
            <h1 class="pt-3 pl-3 pr-3">Duyệt Công Phép</h1>
        @endif

        <div class="card-header header-elements-inline">
            <h4 class="card-title font-weight-bold text-uppercase">
                <?php echo auth()->user()->firstname . " " . auth()->user()->lastname ?> 
                - <?php echo $staff[0][2] ?> 
                - <?php echo auth()->user()->is_manager == 1 ? 'Quản lý' : 'Nhân viên' ?>
            </h4>
        </div>
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
            <form action="{{ action('TimeleaveController@approveTimeLeave') }}" method="GET">
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

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <button class="nav-link active" id="btn_tb_bsc">Bổ sung công</button>
                <li class="nav-item">
                    <button class="nav-link" id="btn_tb_dkp">Đăng kí phép</button>
                </li>
            </ul>
        </div>

        <table class="table datatable-basic" id="tb_bsc">
            <thead>
                <tr>
                    <th>Tên nhân viên</th>
                    <th>Phòng ban</th>
                    <th>Ngày </th>
                    <th>Ngày công</th>
                    <th>Ngày công được tính</th>
                    <th>Ghi chú</th>
                    <th>Phê duyệt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $time_leave)
                    @if($time_leave['type'] == 0)
                            <tr style="
                                <?php 
                                    if($time_leave['special_date_id'] !== null) echo "background-color: #ffe7e7";
                                    else if($time_leave['day_of_week'] == 1 or $time_leave['day_of_week'] == 7)  echo "background-color: #d3ffd4";
                                ?>
                            ">
                            <td>{{ $time_leave['firstname'] . ' ' . $time_leave['lastname'] }}</td>
                            <td>{{ $time_leave['name'] }}</td>
                            <td>
                                {{ $time_leave['day_time_leave'] }}
                                <?php 
                                    if($time_leave['day_of_week'] == 1) {
                                        echo 'Chủ Nhật';
                                    } else {
                                        echo 'Thứ ' . $time_leave['day_of_week'];
                                    }
                                ?>
                                <?php 
                                    if($time_leave['special_date_id'] !== null) {
                                        echo '(Ngày lễ)';
                                    }
                                ?>
                            </td>
                            <td><?php echo $time_leave['time'] == "08:00:00" ? '1' : '0.5' ?></td>
                            <td><?php echo $time_leave['time'] == "08:00:00" ? 1 * $time_leave['multiply'] . '' : 0.5 * $time_leave['multiply'] . '' ?></td>
                            <td>
                                <?php 
                                    if(strlen($time_leave['note']) > 20) echo substr($time_leave['note'], 0, 30) . '...';
                                    else echo $time_leave['note'];    
                                ?>
                            </td>
                            <td>
                                @if($time_leave['is_approved'] == 0)
                                    <span class="badge badge-warning">Chưa phê duyệt</span>
                                @elseif($time_leave['is_approved'] == 2)
                                    <span class="badge badge-success">Quản lý đã phê duyệt</span>
                                @else
                                    <span class="badge badge-primary">Giám đốc đã phê duyệt</span>
                                @endif
                            </td>
                            <td>
                                @if($time_leave['is_approved'] == 1)
                                    Giám đốc đã phê duyệt
                                @elseif($time_leave['is_approved'] == 2 && auth()->user()->id !== 7)
                                    Chờ Giám đốc phê duyệt
                                @elseif( (auth()->user()->id == 7 || (auth()->user()->is_manager == 1 && auth()->user()->department != 2)) || auth()->user()->is_manager == 1 && auth()->user()->department == 2 && $time_leave['department_id'] == 2 )
                                    <?php
                                        $date1=date_create($time_leave['created_at']);
                                        $date2=date_create(date('Y-m-d'));
                                        $diff=date_diff($date1,$date2);
                                    ?>
                                    @if($diff->format("%a") > 1)
                                        <div class="from-group d-flex">
                                            Đã quá 2 ngày kể từ khi bổ sung công
                                        </div>
                                    @else
                                        <div class="from-group d-flex">
                                            <a class="btn btn-info open-detail-time-leave" id="{{ $time_leave['id'] }}" style="color: white; cursor: pointer;">Chi tiết</a>
                                        </div>
                                    @endif                   
                                @endif
                            </td>
                            {{-- @if($time_leave['is_approved'] == 0)
                                <td>
                                    <div class="from-group d-flex">
                                        <a class="btn btn-info open-detail-time-leave" id="{{ $time_leave['id'] }}" style="color: white; cursor: pointer;">Sửa</a>
                                        <a href="{{ action('TimeleaveController@deleteTime') }}?id={{ $time_leave['id'] }}" class="btn btn-danger ml-2" style="color: white; cursor: pointer;">Xóa</a>
                                    </div>
                                </td>
                            @else
                                <td>Quản lý đã phê duyệt, không thể chỉnh sửa!</td>
                            @endif --}}
                        </tr>                        
                    @endif
                @endforeach       
            </tbody>
        </table>

        <table class="table datatable-basic" id="tb_dkp" style="display: none">
             <thead>
                <tr>
                    <th>Tên nhân viên</th>
                    <th>Phòng ban</th>
                    <th>Ngày </th>
                    <th>Ngày công</th>
                    <th>Ghi chú</th>
                    <th>Phê duyệt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $time_leave)
                    @if($time_leave['type'] == 1)
                        <tr>
                            <td>{{ $time_leave['firstname'] . ' ' . $time_leave['lastname'] }}</td>
                            <td>{{ $time_leave['name'] }}</td>
                            <td>
                                {{ $time_leave['day_time_leave'] }}
                                <?php 
                                    if($time_leave['day_of_week'] == 1) {
                                        echo 'Chủ Nhật';
                                    } else {
                                        echo 'Thứ ' . $time_leave['day_of_week'];
                                    }
                                ?>
                                <?php 
                                    if($time_leave['special_date_id'] !== null) {
                                        echo '(Ngày lễ)';
                                    }
                                ?>
                            </td>
                            <td><?php echo $time_leave['time'] == "08:00:00" ? '1 ngày công' : '0.5 ngày công' ?></td>
                            <td>
                                <?php 
                                    if(strlen($time_leave['note']) > 20) echo substr($time_leave['note'], 0, 30) . '...';
                                    else echo $time_leave['note'];    
                                ?>
                            </td>
                            <td>
                                @if($time_leave['is_approved'] == 0)
                                    <span class="badge badge-warning">Chưa phê duyệt</span>
                                @elseif($time_leave['is_approved'] == 2)
                                    <span class="badge badge-success">Quản lý đã phê duyệt</span>
                                @else
                                    <span class="badge badge-primary">Giám đốc đã phê duyệt</span>
                                @endif
                            </td>
                            <td>
                                @if($time_leave['is_approved'] == 1)
                                   
                                @elseif($time_leave['is_approved'] == 2 && auth()->user()->id !== 7)
                                    Chờ Giám đốc phê duyệt
                                @elseif( (auth()->user()->id == 7 || (auth()->user()->is_manager == 1 && auth()->user()->department != 2)) || auth()->user()->is_manager == 1 && auth()->user()->department == 2 && $time_leave['department_id'] == 2 )
                                    <div class="from-group d-flex">
                                        <a class="btn btn-info open-detail-time-leave" id="{{ $time_leave['id'] }}" style="color: white; cursor: pointer;">Chi tiết</a>
                                    </div>
                                @endif
                            </td>
                        </tr>                        
                    @endif
                @endforeach       
            </tbody>
        </table>

        <div id="bsc-modal" class="modal fade" role="dialog"> <!-- modal bsc -->
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ action('TimeleaveController@approvedTimeLeave') }}" method="post" class="form-horizontal">
                    @csrf
                    <div id="html_pending">
                        
                    </div>
                </form> <!-- end form -->
              </div>
            </div>
        </div> <!-- end modal bsc -->
          
    </div>
    <!-- /basic datatable -->
@endsection

@section('scripts')
    <script>

        $( "#btn_tb_bsc" ).click(function() {
            $('#tb_dkp').hide();
            $('#tb_dkp_wrapper').hide();
            $('#tb_bsc').show();
            $('#tb_bsc_wrapper').show();
            $(this).addClass('active');
            $('#btn_tb_dkp').removeClass('active');
        });

        $( "#btn_tb_dkp" ).click(function() {
            $('#tb_bsc').hide();
            $('#tb_bsc_wrapper').hide();
            $('#tb_dkp').show();
            $('#tb_dkp_wrapper').show();
            $(this).addClass('active');
            $('#btn_tb_bsc').removeClass('active');
        });

        $('.open-detail-time-leave').click(function() {
            var id = $(this).attr('id');

            $.ajax({
                url: '{{ action('TimeleaveController@detailStaffApprove') }}',
                Type: 'GET',
                datatype: 'html',
                data:
                {
                    id: id,
                },
                cache: false,
                success: function (data)
                {
                    $('#html_pending').empty().append(data);
                    $('#bsc-modal').modal();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

    </script>
@endsection