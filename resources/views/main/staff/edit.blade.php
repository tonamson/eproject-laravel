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
        <h1 class="pt-3 pl-3 pr-3 font-weight-bold">CẬP NHẬT NHÂN VIÊN</h1>
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

            @if (\Session::has('error'))
                <div class="">
                    <div class="alert alert-danger">
                        {!! \Session::get('error') !!}
                    </div>
                </div>
            @endif
             
                <form action="{{ action('StaffController@postEditStaff') }}" method="post">
                @csrf
            <div class="row">
                <div class="col-md-3">
                        <div class="form-group">
                            <label>Mã Nhân viên:</label>
                            <input type="text" class="form-control" name="txtCode" value="{{$data['code']}}">
                        </div>
                        <div class="form-group">
                            <label>Tên Nhân viên:</label>
                            <input type="text" class="form-control" name="txtFname" value="{{$data['firstname']}}">
                        </div>
                        <div class="form-group">
                            <label>Họ nhân viên:</label>
                            <input type="text" class="form-control" name="txtLname" value="{{$data['lastname']}}"> 
                        </div>
                        <div class="form-group">
                            <label>Phòng Ban:</label>
                            <select class="form-control" name="txtDepartment" color="red" >
                                @foreach($data_department as $dep)
                                <option value="{{ $dep['id'] }}" <?php echo $data['id'] == $dep['id'] ? 'selected' : '' ?>>{{ $dep['name'] }}</option>
                                @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label>Phân Quyền:</label>
                            <select name="txtisManager" color="red" >
                                <option value="0">Nhân viên</option>
                                <option value="1">Quản lý</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ngày Vào:</label>
                            <input type="Date" class="form-control" name="txtJoinat" value="{{$data['joinedAt']}}">
                        </div>
                        <div class="form-group">
                            <label>Ngày sinh:</label>
                            <input type="Date" class="form-control" name="txtDob" value="{{$data['dob']}}">
                        </div>
                         <div class="form-group">
                            <label>Giới tính:</label>
                            <select name="txtGender" color="red" >
                                <option value="1">Nam</option>
                                <option value="0">Nữ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Khu vực:</label>
                            <!-- <input type="text" class="form-control" name="txtGender"> -->
                            <select id="province" class="form-control" color="red" >
                            @foreach($data_reg as $reg)
                                <option value="{{$reg['id']}}" <?php echo $reg['id'] == $district_selected['parent'] ? 'selected' : '' ?> >{{ $reg['name'] }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Thành Phố/Huyện/Xã:</label>
                            <select id="district" class="form-control" name="txtRegional" color="red" >
                            @foreach($data_district as $district)
                            <option value="{{$district['id']}}" <?php echo $district['id'] == $district_selected['id'] ? 'selected' : '' ?>>{{ $district['name'] }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            
                            <input type="text" class="form-control" name="txtRegional" value="{{$data['regional']}}">
                        </div>
                        <div class="form-group">
                            <label>Điện thoại:</label>
                            <input type="text" class="form-control" name="txtPhone" value="{{$data['phoneNumber']}}">
                        </div>
                       <div class="form-group">
                            <label>Email:</label>
                            <input type="text" class="form-control" name="txtEmail" value="{{$data['email']}}">
                        </div>
                        <div class="form-group">
                            <label>Mật Khẩu:</label>
                            <input type="text" class="form-control" name="txtPass" value="{{$data['password']}}">
                        </div>
                         <div class="form-group">
                            <label>CMND:</label>
                            <input type="text" class="form-control" name="txtIDNumber" value="{{$data['idNumber']}}">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh:</label>
                            <input type="text" class="form-control" name="txtPhoto">
                        </div>
                        <div class="form-group">
                            <label>Mặt trước CMND:</label>
                            <input type="text" class="form-control" name="txtIDPhoto">
                        </div>
                        <div class="form-group">
                            <label>Mặt sau CMND:</label>
                            <input type="text" class="form-control" name="txtIDPhoto2">
                        </div>
                        <div class="form-group">
                            <label>Ghi chú:</label>
                            <input type="text" class="form-control" name="txtNote" value="{{$data['note']}}">
                        </div>
                    
                        <button class="btn btn-success" type="submit">Lưu</button>
                        <button class="btn btn-success" type="reset">Reset</button>
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