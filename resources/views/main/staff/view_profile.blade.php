@extends('main._layouts.master')

@section('css')
    <style>
        .text-green {
            color: #008B56
        }

        .btn-link:hover {
            color: #1ab177;
        }

        .card-header {
            background-color: #cccccc40 !important; 
        }

        .card {
            margin-bottom: 0px;
        }
        @media (min-width: 1365px) {
            .infomation-staff {
                margin-left: 20px;
            }
        }

        @media (min-width: 1920px) {
            .infomation-staff {
                margin-left: 80px;
            }
        }

    </style>
@endsection

@section('content')

<div class="row ml-5 mr-5">
    <div class="col-lg-4">
        <div class="wrapper" style="border: 1px solid gray">
            {{-- @dd($data[0]); --}}
            <div class="image text-center">
                <img src="{{ asset('images/user/avatar/'.$staff['photo']) }}" alt="" width="60%" height="auto">
                <h3 class="text-green font-weight-bold"><?php echo $staff['firstname'] . ' ' . $staff['lastname'] ?></h3>
                <h4 class="text-green font-weight-bold">-- <?php echo $staff['department_name'] ?> --</h4>
            </div>
            <div class="infomation-staff" style="font-size: 14px">
                <p>
                    <span class="text-green"><i class="icon-qrcode"></i> Code: </span> <i class="ml-2"><?php echo $staff['code'] ?></i>
                </p>
                <p>
                    <span class="text-green"><i class="icon-calendar"></i> Ngày sinh: </span> <i class="ml-2"> <?php $date=date_create($staff['dob']);echo date_format($date,"d/m/Y");?> </i>
                </p>
                <p>
                    <span class="text-green"><i class="icon-user"></i> Giới tính: </span> <i class="ml-2"> <?php echo $staff['gender'] == 1 ? 'Nam' : 'Nữ' ?> </i>
                </p>
                <p>
                    <span class="text-green"><i class="icon-phone2"></i> Số điện thoại: </span> <i class="ml-2"> <?php echo $staff['phone_number'] ?> </i>
                </p>
                <p>
                    <span class="text-green"><i class="icon-mail5"></i> Địa chỉ email: </span> <i class="ml-2"> <?php echo $staff['email'] ?> </i>
                </p>
                <p>
                    <span class="text-green"><i class="icon-redo2"></i> Ngày vào: </span> <i class="ml-2"> <?php $date=date_create($staff['joined_at']);echo date_format($date,"d/m/Y");?> </i>
                </p>
                <p>
                    <span class="text-green"><i class="icon-user-check"></i> Trạng thái: </span> <i class="ml-2"> <?php echo $staff['off_date'] == null ? 'Enable' : 'Disable' ?> </i>
                </p>
            </div>
            <div class="image text-center mt-5">
                <div class="front">
                    <img src="{{ asset('images/user/cmnd/'.$staff['id_photo']) }}" alt="" width="70%" height="auto">
                    <h6 class="text-green">Ảnh CMND/CCCD mặt trước</h6>
                </div>
                <div class="back mt-4">
                    <img src="{{ asset('images/user/cmnd/'.$staff['id_photo_back']) }}" alt="" width="70%" height="auto">
                    <h6 class="text-green">Ảnh CMND/CCCD mặt sau</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8" style="border: 1px solid gray">
        <div class="row">
            <div id="accordion"  style="width: 100%">
                <div class="card">
                    <div class="card-header p-1" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-green" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="font-size: 17px">
                            Thông tin cơ bản
                        </button>
                    </h5>
                    </div>
    
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body p-0 mt-3 mb-3 ml-4 mr-4">
                            <div class="row">
                                <div class="col-6">
                                    <div class="control-group row">
                                        <label for="" class="col-4 p-0">Họ và tên: </label>
                                        <div class="control col-8"><?php echo $staff['firstname'] . ' ' . $staff['lastname'] ?></div>
                                    </div>
                                    <div class="control-group row">
                                        <label for="" class="col-4 p-0">Phòng ban: </label>
                                        <div class="control col-8"><?php echo $staff['department_name'] ?></div>
                                    </div>
                                    <div class="control-group row">
                                        <label for="" class="col-4 p-0">Chức danh: </label>
                                        <div class="control col-8"><?php echo $staff['is_manager'] == 1 ? 'Quản lý' : 'Nhân viên' ?></div>
                                    </div>
                                    <div class="control-group row">
                                        <label for="" class="col-4 p-0">Xã/Huyện: </label>
                                        <div class="control col-8"><?php echo $staff['district'] ?></div>
                                    </div>
                                    <div class="control-group row">
                                        <label for="" class="col-4 p-0">Tỉnh/Thành phố: </label>
                                        <div class="control col-8"><?php echo $staff['province'] ?></div>
                                    </div>
                                    <div class="control-group row">
                                        <label for="" class="col-4 p-0">Ngày phép còn: </label>
                                        <div class="control col-8"><?php echo $staff['day_of_leave'] ?></div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="control-group row">
                                        <label for="" class="col-4 p-0">Ngày vào: </label>
                                        <div class="control col-8"><?php $date=date_create($staff['joined_at']);echo date_format($date,"d/m/Y");?></div>
                                    </div>
                                    <div class="control-group row">
                                        <label for="" class="col-4 p-0">Ngày nghỉ việc: </label>
                                        <div class="control col-8"><?php if($staff['off_date']) { $date_off=date_create($staff['off_date']);echo date_format($date_off,"d/m/Y"); }?></div>
                                    </div>
                                    <div class="control-group row">
                                        <label for="" class="col-4 p-0">Được tạo bởi: </label>
                                        <div class="control col-8"><?php echo $staff['name_staff_create'] ?></div>
                                    </div>
                                    <div class="control-group row">
                                        <label for="" class="col-4 p-0">Được tạo lúc: </label>
                                        <div class="control col-8"><?php $date=date_create($staff['created_at']);echo date_format($date,"d/m/Y H:i:s");?></div>
                                    </div>
                                    <div class="control-group row">
                                        <label for="" class="col-4 p-0">Chỉnh sửa bởi: </label>
                                        <div class="control col-8"><?php echo $staff['name_staff_update'] ?></div>
                                    </div>
                                    <div class="control-group row">
                                        <label for="" class="col-4 p-0">Chỉnh sửa lúc: </label>
                                        <div class="control col-8"><?php $date=date_create($staff['updated_at']);echo date_format($date,"d/m/Y H:i:s");?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-1" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-green collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="font-size: 17px">
                            Trình độ học vấn
                        </button>
                    </h5>
                    </div>
                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body p-0 mt-3 mb-3 ml-4 mr-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Cấp bậc</th>
                                        <th>Tên cấp bậc</th>
                                        <th>Trường</th>
                                        <th>Ngành</th>
                                        <th>Năm tốt nghiệp</th>
                                        <th>Xếp loại</th>
                                        <th>Phương thức</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?> 
                                    @foreach ($educations as $education)
                                        <tr>
                                            <td><?php echo $count ?></td>
                                            <td>{{ $education['level'] }}</td>
                                            <td>{{ $education['levelName'] }}</td>
                                            <td>{{ $education['school'] }}</td>
                                            <td>{{ $education['fieldOfStudy'] }}</td>
                                            <td>{{ $education['graduatedYear'] }}</td>
                                            <td>{{ $education['grade'] }}</td>
                                            <td>{{ $education['modeOfStudy'] }}</td>
                                        </tr>
                                        <?php $count++; ?> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-1" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-green collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="font-size: 17px">
                            Hợp đồng
                        </button>
                    </h5>
                    </div>
                    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body p-0 mt-3 mb-3 ml-4 mr-4">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        
    });
</script>

@endsection

@section('scripts')
    <script></script>
@endsection
