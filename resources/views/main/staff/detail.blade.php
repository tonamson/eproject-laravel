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
						<h3 class="pt-3 pl-3 pr-3 font-weight-bold">CHI TIẾT NHÂN VIÊN</h3>
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
                    

					<div class="card-body">
						<form action="#" method="post" enctype="multipart/form-data">
                        @csrf
							<div class="row">
                            <div class="col-md-6">
									<fieldset>
					                	<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Personal</legend>

										<div class="row">
                                            <div class="col-md-6">
												<div class="form-group">
													<label>ID Nhân viên:(*)</label>
													<b><label>{{$data['id']}}</label></b>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Mã Nhân viên:(*)</label>
													<b><label>{{$data['code']}}</label></b>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Họ nhân viên:</label>
                                                    <b><label>{{$data['lastname']}} {{$data['firstname']}}</label></b>
												</div>
											</div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>CMND:(*)</label>
                                                    <b><label>{{$data['idNumber']}}</label></b>
                                                </div>
										    </div>
                                           
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                <label>Phân Quyền:(*)</label>
                                                    <b>@if($data['isManager'] == 1)
                                                        Quản lý
                                                    @else
                                                        Nhân viên
                                                    @endif</b>
					                            </div>
											</div>
                                            <div class="col-md-6" hidden>
												<div class="form-group">
                                                <label>Phòng Ban:(*)</label>
                                                <b>
                                                    @foreach ($data_department as $dep)
                                                    @if ($data['department'] == $dep['id'])
                                                    <td>{{$dep['name']}}</td>
                                                    @endif
                                                    @endforeach
                                                </b> 
												</div>
											</div>
                                            <div class="col-md-6">
												<div class="form-group">
                                                    <label>Giới tính:(*)</label>
                                                    <b>@if($data['isManager'] == 1)
                                                        Nam
                                                    @else
                                                        Nữ
                                                    @endif</b>
												</div>
											</div>
										</div>

                                        <div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                <label>Ngày sinh:</label>
                                                    <b><label>{{$data['dob']}}</label></b>
					                            </div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Ngày Vào:(*)</label>
                                                    <b><label>{{$data['joinedAt']}}</label></b>
												</div>
											</div>
										</div>

                                        <div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                <label>Khu vực:(*)</label>
                                                    <label id="province" class="form-control form-control-select2" color="red"  data-fouc >
                                                    @foreach($data_reg as $reg)
                                                        <option value="{{$reg['id']}}" <?php echo $reg['id'] == $district_selected['parent'] ? 'selected' : '' ?> >{{ $reg['name'] }}</option>
                                                    @endforeach
                                                </lable>
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
                                                    <b><label>{{$data['phoneNumber']}}</label></b>
					                            </div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
                                                    <label>Email:</label>
                                                    <b><label>{{$data['email']}}</label></b>
												</div>
											</div>
										</div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Phòng ban:</label>
                                                        <b>
                                                            @foreach ($data_department as $dep)
                                                            @if ($data['department'] == $dep['id'])
                                                            <td>{{$dep['name']}}</td>
                                                            @endif
                                                            @endforeach
                                                        </b>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Thời gian tạo:</label>
                                                        <b><label>{{$data['createdAt']}}</label></b>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Học Trường:</label>
                                                        <b>
                                                        @foreach ($educa as $de)
                                                            @if($data['id'] == $de['staffId'] )
                                                             
                                                                <td>{{$de['school']}}</td><br>

                                                            @endif
                                                        @endforeach
                                                        </b>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Trình độ:</label>
                                                        <b>
                                                        @foreach ($educa as $de)
                                                            @if($data['id'] == $de['staffId'] )
                                                       
                                                                <td>{{$de['levelName']}}</td><br>
                                                            
                                                            @endif
                                                        @endforeach
                                                        </b>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Chuyên ngành:</label>
                                                        <b>
                                                        @foreach ($educa as $de)
                                                            @if($data['id'] == $de['staffId'] )
                                                                <td>{{$de['fieldOfStudy']}}</td><br>
                                                            @endif
                                                        @endforeach
                                                        </b>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Xếp loại:</label>
                                                        <b>
                                                        @foreach ($educa as $de)
                                                            @if($data['id'] == $de['staffId'] )
                                                                <td>{{$de['grade']}}</td><br>
                                                            @endif
                                                        @endforeach
                                                        </b>
                                                    </div>
                                                </div>
                                            </div>


									</fieldset>
								</div>

								<div class="col-md-6">
									<fieldset>
										<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Picture</legend>

                                        <div class="form-group">
                                            <label>Hình ảnh:</label>
                                            <p><img width="70px" height="70px" src="{{ asset($data['photo']) }}"></p>
										</div>

										<div class="form-group">
                                            <label>Mặt trước CMND:</label>
                                            <p><img width="70px" height="70px" src="{{ asset($data['idPhoto']) }}"></p>
										</div>

                                        <div class="form-group">
                                            <label>Mặt sau CMND:</label>
                                            <p><img width="70px" height="70px" src="{{ asset($data['idPhotoBack']) }}"></p>
										</div>

										<div class="form-group">
											<label>Ghi chú:</label>
                                            <b><label>{{$data['note']}}</label></b>
										</div>

									</fieldset>
								</div>
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