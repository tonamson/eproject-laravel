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
	<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/form_layouts.js')}}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable_init.js') }}"></script>
@endsection

@section('content')
    <!-- Basic datatable -->
    <div class="card">
        <h1 class="pt-3 pl-3 pr-3">Bổ Sung Công / Đăng Kí Phép</h1>
        <div class="card-header header-elements-inline">
            <h4 class="card-title font-weight-bold text-uppercase">
                <?php echo auth()->user()->firstname . " " . auth()->user()->lastname ?> 
                - <?php echo $staff[0][2] ?> 
                - <?php echo auth()->user()->is_manager == 1 ? 'Quản lý' : 'Nhân viên' ?>
            </h4>
            <h4 class="card-title font-weight-bold text-uppercase">
                Số ngày phép : <?php echo auth()->user()->day_of_leave ?> ngày 
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
            <form action="{{ action('TimeleaveController@index') }}" method="GET">
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

            <div class="form-group d-flex">
                <div class="">
                    <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">Bổ Sung Công</button>
                </div>
                <div class="ml-1">
                    <button id="register_leave" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter2">Đăng Kí Phép</button>
                </div>
            </div>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <button class="nav-link active" id="btn_tb_bsc">Bổ sung công</button>
                <li class="nav-item">
                  <button class="nav-link" id="btn_tb_dkp">Đăng kí phép</button>
                </li>
            </ul>
        </div>
        <!-- Modal bsc -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ action('TimeleaveController@createTime') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Bổ Sung Công</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Ngày bổ sung:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control day_leave" name="day_leave" value="" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Yêu cầu điều chỉnh:</label>
                                <div class="col-lg-9">
                                    <select class="form-control" name="number_day_leave" id="number_day_leave" required>
                                        <option value="1">Một ngày</option>
                                        <option value="0.5">Nửa ngày</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Hình ảnh(Nếu có):</label>
                                <div class="col-lg-9">
                                    <input type="file" class="form-input-styled" name="txtImage" data-fouc>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Lý do:</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="note_bsc" id="note_bsc" cols="20" rows="10" placeholder="VD: Quên check in, Quên check out, ..." required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>

         <!-- Modal dkp -->
        <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ action('TimeleaveController@createLeave') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Đăng Kí Phép</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Ngày đăng kí phép:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control day_leave" name="day_leave" value="" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Yêu cầu phép:</label>
                                <div class="col-lg-9">
                                    <select class="form-control" name="number_day_leave" id="number_day_leave" required>
                                        <option value="1">Một ngày</option>
                                        <option value="0.5">Nửa ngày</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Lý do:</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="note_dkp" id="note_dkp" cols="20" rows="10" placeholder="VD: Bận việc gia đình, Đi học, ..." required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>
  
        <table class="table datatable-basic" id="tb_bsc">
            <thead>
                <tr>
                    <th>Ngày </th>
                    <th>Ngày công</th>
                    <th>Loại</th>
                    <th>Ghi chú</th>
                    <th>Phê duyệt</th>
                    <th>Sửa / Xóa</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $time_leave)
                    @if($time_leave['type'] == 0)
                        <tr>
                            <td>{{ $time_leave['dayTimeLeave'] }}</td>
                            <td><?php echo $time_leave['time'] == "08:00:00" ? '1 ngày công' : '0.5 ngày công' ?></td>
                            <td><?php echo $time_leave['type'] == 0 ? 'Bổ sung công' : 'Đăng kí phép' ?></td>
                            <td>
                                <?php 
                                    if(strlen($time_leave['note']) > 20) echo substr($time_leave['note'], 0, 30) . '...';
                                    else echo $time_leave['note'];    
                                ?>
                            </td>
                            <td>
                                @if($time_leave['isApproved'] == 0)
                                    <span class="badge badge-warning">Chưa phê duyệt</span>
                                @elseif($time_leave['isApproved'] == 2)
                                    <span class="badge badge-success">Quản lý đã phê duyệt</span>
                                @else
                                    <span class="badge badge-primary">Giám đốc đã phê duyệt</span>
                                @endif
                            </td>
      
                            @if($time_leave['isApproved'] == 0 || ($time_leave['isApproved'] == 2 && auth()->user()->is_manager == 1))
                                <?php
                                    $date1=date_create($time_leave['createdAt']);
                                    $date2=date_create(date('Y-m-d'));
                                    $diff=date_diff($date1,$date2);
                                ?>
                                @if($diff->format("%a") > 1)
                                    <td>
                                        <div class="from-group d-flex">
                                            Đã quá 2 ngày kể từ khi bổ sung công
                                        </div>
                                    </td>
                                @else
                                    <td>
                                        <div class="from-group d-flex">
                                            <a class="btn btn-info open-detail-time-leave" id="{{ $time_leave['id'] }}" style="color: white; cursor: pointer;">Sửa</a>
                                            <a href="{{ action('TimeleaveController@deleteTime') }}?id={{ $time_leave['id'] }}" class="btn btn-danger ml-2" style="color: white; cursor: pointer;">Xóa</a>
                                        </div>
                                    </td>
                                @endif
                            @elseif($time_leave['isApproved'] == 2)
                                <td>Quản lý đã phê duyệt, chờ giám đốc phê duyệt!</td>
                            @else
                                <td>Giám đốc đã phê duyệt, không thể chỉnh sửa!</td>
                            @endif
                        </tr>                        
                    @endif
                @endforeach       
            </tbody>
        </table>

        <table class="table datatable-basic2" id="tb_dkp" style="display: none">
            <thead>
                <tr>
                    <th>Ngày </th>
                    <th>Ngày công</th>
                    <th>Loại</th>
                    <th>Ghi chú</th>
                    <th>Phê duyệt</th>
                    <th>Sửa / Xóa</th>
                </tr>
                    
            </thead>
            <tbody>
                @foreach ($data as $time_leave)
                    @if($time_leave['type'] == 1)
                        <tr>
                            <td>{{ $time_leave['dayTimeLeave'] }}</td>
                            <td><?php echo $time_leave['time'] == "08:00:00" ? '1 ngày công' : '0.5 ngày công' ?></td>
                            <td><?php echo $time_leave['type'] == 0 ? 'Bổ sung công' : 'Đăng kí phép' ?></td>
                            <td>
                                <?php 
                                    if(strlen($time_leave['note']) > 20) echo substr($time_leave['note'], 0, 30) . '...';
                                    else echo $time_leave['note'];    
                                ?>
                            </td>
                            <td>
                                @if($time_leave['isApproved'] == 0)
                                    <span class="badge badge-warning">Chưa phê duyệt</span>
                                @elseif($time_leave['isApproved'] == 2)
                                    <span class="badge badge-success">Quản lý đã phê duyệt</span>
                                @else
                                    <span class="badge badge-primary">Giám đốc đã phê duyệt</span>
                                @endif
                            </td>
                            @if($time_leave['isApproved'] == 0 || ($time_leave['isApproved'] == 2 && auth()->user()->is_manager == 1))
                                <td>
                                    <div class="from-group d-flex">
                                        <a class="btn btn-info open-detail-dkp" id="{{ $time_leave['id'] }}" style="color: white; cursor: pointer;">Sửa</a>
                                        <a href="{{ action('TimeleaveController@deleteTime') }}?id={{ $time_leave['id'] }}" class="btn btn-danger ml-2" style="color: white; cursor: pointer;">Xóa</a>
                                    </div>
                                </td>
                            @elseif($time_leave['isApproved'] == 2)
                                <td>Quản lý đã phê duyệt, chờ giám đốc phê duyệt!</td>
                            @else
                                <td>Giám đốc đã phê duyệt, không thể chỉnh sửa!</td>
                            @endif
                        </tr>                        
                    @endif
                @endforeach         
            </tbody>
        </table>

        <div id="bsc-modal" class="modal fade" role="dialog"> <!-- modal bsc -->
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ action('TimeleaveController@updateTime') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div id="html_pending">
                        
                    </div>
                </form> <!-- end form -->
              </div>
            </div>
        </div> <!-- end modal bsc -->

        <div id="dkp-modal" class="modal fade" role="dialog"> <!-- modal dkp -->
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ action('TimeleaveController@updateTime') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div id="html_pending">
                        
                    </div>
                </form> <!-- end form -->
              </div>
            </div>
        </div> <!-- end modal dkp -->
          
    </div>
    <!-- /basic datatable -->
@endsection

@section('scripts')
    <script>
        $('.day_bsc').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

        $('.day_leave').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

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
                url: '{{ action('TimeleaveController@detailTime') }}',
                Type: 'POST',
                datatype: 'text',
                data:
                {
                    id: id,
                },
                cache: false,
                success: function (data)
                {
                    console.log(data);
                    $('#html_pending').empty().append(data);
                    $('#bsc-modal').modal();
                }
            });
        });

        $('.open-detail-dkp').click(function() {
            var id = $(this).attr('id');

            $.ajax({
                url: '{{ action('TimeleaveController@detailLeave') }}',
                Type: 'POST',
                datatype: 'text',
                data:
                {
                    id: id,
                },
                cache: false,
                success: function (data)
                {
                    console.log(data);
                    $('#html_pending').empty().append(data);
                    $('#bsc-modal').modal();
                }
            });
        });

    </script>
@endsection