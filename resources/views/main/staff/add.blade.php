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
    <script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/form_layouts.js')}}"></script>

@endsection


@section('content')
    <!-- Basic datatable -->
    	<!-- 2 columns form -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<b><h3 class="card-title">THÊM NHÂN VIÊN MỚI</h3></b>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>
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

                    @if($errors->any())
                    <div class="alert alert-danger border-0 alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        <p><b>Dữ liệu đầu vào không chính xác:</b></p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

					<div class="card-body">
						<form action="{{ route('postAddStaff') }}" method="post" enctype="multipart/form-data">
                        @csrf
							<div class="row">
                            <div class="col-md-6">
									<fieldset>
					                	<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Imformation</legend>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Mã Nhân viên:(*)</label>
													<input type="text" class="form-control" name="txtCode" value="{{ old('txtCode') }}" require  placeholder="Nhập Mã Nhân viên">
												</div>
											</div>

                                            <div class="col-md-6">
												<div class="form-group">
                                                <label>Phân Quyền:(*)</label>
                                                    <!-- <input type="text" class="form-control" name="txtGender"> -->
                                                    <select class="form-control" name="txtisManager" color="red" >
                                                        <option value="0">Nhân viên</option>
                                                        <option value="1">Quản lý</option>
                                                    </select>
					                            </div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Họ nhân viên:</label>
                                                    <input type="text" class="form-control" name="txtLname" value="{{ old('txtLname') }}" placeholder="Nhập Họ">
												</div>
											</div>
                                            <div class="col-md-6">
												<div class="form-group">
                                                    <label>Tên Nhân viên:(*)</label>
                                                    <input type="text" class="form-control" name="txtFname" value="{{ old('txtFname') }}" require  placeholder="Nhập Tên">
												</div>
											</div>
											
										</div>

										<div class="row">
                                        <div class="col-md-6">
												<div class="form-group">
                                                <label>Phòng Ban:(*)</label>
                                                    <select class="form-control form-control-select2" name="txtDepartment" value="{{ old('txtDepartment') }}" color="red"  data-fouc>
                                                    @foreach($data_department as $dep)
                                                    <option value="{{ $dep['id'] }}">{{ $dep['name'] }}</option>
                                                    @endforeach
                                                    </select>
												</div>
											</div>
                                            
                                            <div class="col-md-6">
												<div class="form-group">
                                                <label>Ngày sinh:</label>
                                                  <input type="Date" class="form-control" name="txtDob"  value="{{ old('txtDob') }}">
					                            </div>
											</div>
										
										</div>

                                        <div class="row">
                                        <div class="col-md-6">
												<div class="form-group">
                                                    <label>Ngày Vào:(*)</label>
                                                    <input type="Date" class="form-control" name="txtJoinat" value="{{ old('txtJoinat') }}">
												</div>
											</div>
										

											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Giới tính:(*)</label>
                                                    <select class="form-control" name="txtGender" color="red" >
                                                        <option value="1">Nam</option>
                                                        <option value="0">Nữ</option>
                                                    </select>
												</div>
											</div>
										</div>

                                        <div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                <label>Khu vực:(*)</label>
                                                    <!-- <input type="text" class="form-control" name="txtGender"> -->
                                                    <select id="province" class="form-control form-control-select2" color="red"  data-fouc >
                                                    @foreach($data_reg as $reg)
                                                    <option value="{{$reg['id']}}">{{ $reg['name'] }}</option>
                                                    @endforeach
                                                    </select>
					                            </div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
                                                <label>Thành Phố/Huyện/Xã:(*)</label>
                                                    <select id="district" class="form-control form-control-select2" name="txtRegional" color="red" data-fouc >
                                                    @foreach($data_district as $district)
                                                    <option value="{{$district['id']}}">{{ $district['name'] }}</option>
                                                    @endforeach
                                                    </select>
												</div>
											</div>
										</div>

                                        <div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Điện thoại:</label>
                                                    <input type="number" class="form-control" name="txtPhone" value="{{ old('txtPhone') }}" placeholder="Nhập số điện thoại">
					                            </div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Email:</label>
                                                    <input type="text" class="form-control" name="txtEmail" value="{{ old('txtEmail') }}" placeholder="Nhập Email abc12@exam.com">
												</div>
											</div>
										</div>

									</fieldset>
								</div>

								<div class="col-md-6">
									<fieldset>
										<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Imformation</legend>

										<div class="form-group" hidden>
                                            <label>Mật Khẩu:(*)</label>
											<input type="password" class="form-control" name="txtPass" placeholder="Nhập mật khẩu" require>
										</div>

										<div class="form-group">
                                            <label>CMND:(*)</label>
											<input type="text" class="form-control" name="txtIDNumber" placeholder="Nhập số CMND" value="{{ old('txtIDNumber') }}"  require>
										</div>

										<div class="form-group">
                                            <label>Hình ảnh:</label>
											<input type="file" class="form-input-styled" name="txtPhoto" data-fouc>
										</div>

                                        <div class="form-group">
                                            <label>Mặt trước CMND:</label>
											<input type="file" class="form-input-styled" name="txtIDPhoto" data-fouc>
										</div>

                                        <div class="form-group">
                                            <label>Mặt sau CMND:</label>
											<input type="file" class="form-input-styled"  name="txtIDPhoto2" data-fouc>
										</div>

										<div class="form-group">
											<label>Ghi chú:</label>
											<textarea rows="5" cols="5" class="form-control" name="txtNote" value="{{ old('txtNote') }}" placeholder="Nhập Ghi chú" ></textarea>
										</div>
									</fieldset>
								</div>
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-primary">Lưu <i class="icon-paperplane ml-2"></i></button>
                                <button type="reset" class="btn btn-success">Reset <i class="icon-paperplane ml-2"></i></button>
							</div>
						</form>
					</div>
				</div>
				<!-- /2 columns form -->
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
