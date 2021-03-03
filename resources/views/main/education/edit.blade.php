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
        <h1 class="pt-3 pl-3 pr-3 font-weight-bold">CẬP NHẬT VĂN BẰNG NHÂN VIÊN</h1>
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
             
                <form action="{{action('EducationController@postEditEducation')}}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="row">
                <div class="col-md-3">
                        <div class="form-group">
                            <label>ID:</label>
                            <input type="text" class="form-control" name="txtID" value="{{$data['id']}}" readonly>
                        </div>
                        <div class="form-group">
                            <label>ID Nhân viên:</label>
                            <input type="text" class="form-control" name="txtStaffID" value="{{$data['staffId']}}">
                        </div>
                        <div class="form-group">
                            <label>Cấp Bậc:</label>
                            <input type="text" class="form-control" name="txtLevel" value="{{$data['level']}}">
                        </div>
                        <div class="form-group">
                            <label>Tên Cấp Bậc:</label>
                            <input type="text" class="form-control" name="txtLevelName" value="{{$data['levelName']}}">
                        </div>
                        <div class="form-group">
                            <label>Tên Trường:</label>
                            <input type="text" class="form-control" name="txtSchool" value="{{$data['school']}}">
                        </div>
                        <div class="form-group">
                            <label>Chuyên ngành:</label>
                            <input type="text" class="form-control" name="txtFieldOfStudy" value="{{$data['fieldOfStudy']}}">
                        </div>
                        <div class="form-group">
                            <label>Năm tốt nghiện:</label>
                            <input type="text" class="form-control" name="txtGraduatedYear" value="{{$data['graduatedYear']}}">
                        </div>
                        <div class="form-group">
                            <label>Xếp loại:</label>
                            <input type="text" class="form-control" name="txtGrade" value="{{$data['grade']}}">
                        </div>
                        <div class="form-group">
                            <label>Hình thức học:</label>
                            <input type="text" class="form-control" name="txtModeOf" value="{{$data['modeOfStudy']}}">
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