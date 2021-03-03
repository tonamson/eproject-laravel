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

        .wrap-select {
	width: 302px;
	overflow: hidden;
}
.wrap-select select {
	width: 320px;
	margin: 0;
	background-color: #212121;
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
    <script src="{{ asset('assets/js/datatable_init.js') }}"></script>

@endsection


@section('content')
    <!-- Basic datatable -->
    <div class="card">
        <h1 class="pt-3 pl-3 pr-3 font-weight-bold">CHI TIẾT NHÂN VIÊN</h1>
        <div class="card-header header-elements-inline">
 
        </div>
        <div class="card-body">
        @if (\Session::has('success'))
                <div class="">
                    <div class="alert alert-success">
                        {!! \Session::get('success') !!}
                    </div>
                </div>
            @endif

            @if (session('message'))
                <div class="">
                    <div class="alert alert-primary">
                        {!! session('message') !!}
                    </div>
                </div>
            @endif
                <form action="#" method="post" enctype="multipart/form-data">
                @csrf
            <div class="row">
                <div class="col-md-3">
                        <div class="form-group">
                            <label >Mã Nhân viên:</label>
                            <b><label>{{$data['id']}}</label></b>
                        </div>
                        <div class="form-group">
                            <label>Mã Nhân viên:</label>
                            <b><label>{{$data['code']}}</label></b>
                        </div>
                        <div class="form-group">
                            <label>Họ tên Nhân viên:</label>
                            <b><label>{{$data['lastname']}} {{$data['firstname']}}</label></b>
                        </div>
                        <div class="form-group">
                            <label>Phòng Ban:</label>
                            <b>
                                @foreach ($data_department as $dep)
                                @if ($data['department'] == $dep['id'])
                                <td>{{$dep['name']}}</td>
                                @endif
                                @endforeach
                            </b>
                        </div>
                        <div class="form-group">
                            <label>Phân Quyền:</label>
                            <b>@if($data['isManager'] == 1)
                                Quản lý
                            @else
                                Nhân viên
                            @endif</b>
                        </div>
                        <div class="form-group">
                            <label>Ngày Vào:</label>
                            <b><label>{{$data['joinedAt']}}</label></b>
                        </div>
                        <div class="form-group">
                            <label>Ngày sinh:</label>
                            <b><label>{{$data['dob']}}</label></b>
                        </div>
                         <div class="form-group">
                            <label>Giới tính:</label>
                            <b>@if($data['isManager'] == 1)
                                Nam
                            @else
                                Nữ
                            @endif</b>
                            </div>
                        <div class="form-group">
                            <label>Điện thoại:</label>
                            <b><label>{{$data['phoneNumber']}}</label></b>
                        </div>
                       <div class="form-group">
                            <label>Email:</label>
                            <b><label>{{$data['email']}}</label></b>
                        </div>
                         <div class="form-group">
                            <label>CMND:</label>
                            <b><label>{{$data['idNumber']}}</label></b>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh:</label>
                            <p><img width="150px" height="150px" src="{{ asset($data['photo']) }}"></p>
                        </div>
                        <div class="form-group">
                            <label>Mặt trước CMND:</label>
                            <p><img width="150px" height="150px" src="{{ asset($data['idPhoto']) }}"></p>
                        </div>
                        <div class="form-group">
                            <label>Mặt sau CMND:</label>
                            <p><img width="150px" height="150px" src="{{ asset($data['idPhotoBack']) }}"></p>
                        </div>
                        <div class="form-group">
                            <label>Ghi chú:</label>
                            <b><label>{{$data['note']}}</label></b>
                        </div>
                        <div class="form-group">
                            <label>Tạo bởi:</label>
                            <b><label>{{$data['createdBy']}}</label></b>
                        </div>
                        <div class="form-group">
                            <label>Thời gian tạo:</label>
                            <b><label>{{$data['createdAt']}}</label></b>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /basic datatable -->
@endsection

@section('scripts')
    <script>
        $('#province').on('change', function() {
            var parent = this.value;

            $.ajax({
                url: '{{ action('StaffController@loadRegional') }}',
                Type: 'GET',
                datatype: 'text',
                data:
                {
                    parent: parent,
                },
                cache: false,
                success: function (data)
                {
                    var obj = $.parseJSON( data);
                    $('#district').empty();
                    for (var i = 0; i < obj.length; i++) {
                        $('#district').append('<option value="'+obj[i]['id']+'">'+obj[i]['name']+'</option>');
                    }
                }
            });
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

    </script>



@endsection