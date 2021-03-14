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
                    <h1 class="pt-3 pl-3 pr-3">Cập Nhật Nhân Viên</h1>
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

                    @if (session('message'))
                        <div class="">
                            <div class="alert alert-primary">
                                {!! session('message') !!}
                            </div>
                        </div>
                    @endif
<!-- aler validate -->
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
						<form action="{{ action('StaffController@postEditStaff') }}" method="post" enctype="multipart/form-data">
                        @csrf
							<div class="row">
                            <div class="col-md-6">
									<fieldset>
					                	<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Imformation</legend>

										<div class="row">
                                            <div class="col-md-6">
												<div class="form-group">
													<label>ID Nhân viên:(*)</label>
													<input type="text" class="form-control" name="txtID"  value="{{$data['id']}}" readonly>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Mã Nhân viên:(*)</label>
													<input type="text" class="form-control" name="txtCode"  value="{{$data['code']}}" readonly >
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Họ nhân viên:</label>
                                                    <input type="text" class="form-control" name="txtLname" value="{{$data['lastname']}}">
												</div>
											</div>

                                            <div class="col-md-6">
												<div class="form-group">
                                                    <label>Tên Nhân viên:(*)</label>
                                                    <input type="text" class="form-control" name="txtFname" value="{{$data['firstname']}}" >
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                <label>Phân Quyền:(*)</label>
                                                    <!-- <input type="text" class="form-control" name="txtGender"> -->
                                                    <select class="form-control" name="txtisManager" color="red" >
                                                        <@if($data['isManager']==0)
                                                            <option value="0">Nhân viên</option>
                                                            <option value="1">Quản lý</option>
                                                            @else
                                                            <option value="1">Quản lý</option>
                                                            <option value="0">Nhân viên</option>
                                                        @endif
                                                    </select>
					                            </div>
											</div>
                                            <div class="col-md-6" hidden>
												<div class="form-group">
                                                <label>Phòng Ban:(*)</label>
                                                    <input type="text" class="form-control" name="txtDepartment" value="{{$data['department']}}"> 
												</div>
											</div>
                                            <div class="col-md-6">
												<div class="form-group">
                                                    <label>Giới tính:(*)</label>
                                                    <select class="form-control" name="txtGender" color="red" >
                                                        @if($data['gender']==0)
                                                            <option value="0">Nữ</option>
                                                            <option value="1">Nam</option>
                                                            @else
                                                            <option value="1">Nam</option>
                                                            <option value="0">Nữ</option>
                                                        @endif
                                                    </select>
												</div>
											</div>
										</div>

                                        <div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                <label>Ngày sinh:</label>
                                                  <input type="Date" class="form-control" value="{{$data['dob']}}" name="txtDob">
					                            </div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Ngày Vào:(*)</label>
                                                    <input type="Date" class="form-control" value="{{$data['joinedAt']}}" name="txtJoinat">
												</div>
											</div>
										</div>

                                        <div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                <label>Khu vực:(*)</label>
                                                    <select id="province" class="form-control form-control-select2" color="red"  data-fouc >
                                                    @foreach($data_reg as $reg)
                                                        <option value="{{$reg['id']}}" <?php echo $reg['id'] == $district_selected['parent'] ? 'selected' : '' ?> >{{ $reg['name'] }}</option>
                                                    @endforeach
                                                    </select>
					                            </div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
                                                <label>Thành Phố/Huyện/Xã:(*)</label>
                                                    <select id="district" class="form-control form-control-select2" name="txtRegional" color="red" data-fouc >
                                                    @foreach($data_district as $district)
                                                        <option value="{{$district['id']}}" <?php echo $district['id'] == $district_selected['id'] ? 'selected' : '' ?>>{{ $district['name'] }}</option>
                                                    @endforeach
                                                    </select>
												</div>
											</div>
										</div>

                                        <div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Điện thoại:</label>
                                                    <input type="number" class="form-control" name="txtPhone" value="{{$data['phoneNumber']}}">
					                            </div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Email:</label>
                                                    <input type="text" class="form-control" name="txtEmail" value="{{$data['email']}}">
												</div>
											</div>
										</div>

                                        <div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Tạo bởi:</label>
                                                    <input type="number" class="form-control" name="txtCreateBy" value="{{$data['createdBy']}}" readonly>
					                            </div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Thời gian tạo:</label>
                                                    <input type="text" class="form-control" name="txtCreatedAt" value="{{$data['createdAt']}}" readonly>
												</div>
											</div>
										</div>

									</fieldset>
								</div>

								<div class="col-md-6">
									<fieldset>
										<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Imformation</legend>
                                      

                                        <div class="form-group">
                                            <label>Mật Khẩu:(*)</label>
											<input type="hidden" class="form-control" name="txtPassOld" value="{{$data['password']}}" >
											<input type="password" class="form-control" name="txtPass" value="" >
										</div>

										<div class="form-group">
                                            <label>CMND:(*)</label>
											<input type="text" class="form-control" name="txtIDNumber" value="{{$data['idNumber']}}" >
										</div>

                                        <div class="form-group" hidden>
                                            <label>Hình ảnh:</label>
											<input type="text" class="form-input-styled" name="txtImagesOld" value="{{$data['photo']}}" data-fouc>
										</div>

                                        <div class="form-group">
                                            <label>Hình ảnh:</label>
                                            <p><img width="50px" height="50px" src="{{ asset($data['photo']) }}"></p>
											<input type="file" class="form-input-styled" name="txtPhoto" data-fouc>
										</div>

                                        <div class="form-group" hidden>
                                            <label>Mặt trước CMND:</label>
											<input type="text" class="form-input-styled" name="txtImagesOld2" value="{{$data['idPhoto']}}" data-fouc>
										</div>
										<div class="form-group">
                                            <label>Mặt trước CMND:</label>
                                            <p><img width="50px" height="50px" src="{{ asset($data['idPhoto']) }}"></p>
											<input type="file" class="form-input-styled" name="txtIDPhoto" data-fouc>
										</div>

                                        <div class="form-group" hidden>
                                            <label>Mặt sau CMND:</label>
											<input type="text" class="form-input-styled" name="txtImagesOld3" value="{{$data['idPhotoBack']}}" data-fouc>
										</div>
                                        <div class="form-group">
                                            <label>Mặt sau CMND:</label>
											<p><img width="50px" height="50px" src="{{ asset($data['idPhotoBack']) }}"></p>
											<input type="file" class="form-input-styled" name="txtIDPhoto2" data-fouc>
										</div>

										<div class="form-group">
											<label>Ghi chú:</label>
											<textarea rows="2" cols="5" class="form-control" name="txtNote" value="{{$data['note']}}"></textarea>
										</div>
									</fieldset>
								</div>
							</div>
							<div class="text-right">
                                <a class="btn btn-primary" role="button" href="{{ action('StaffController@index') }}" style="color:white;">Quay lại</a>
								<button type="submit" class="btn btn-success">Lưu <i class="icon-paperplane ml-2"></i></button>
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