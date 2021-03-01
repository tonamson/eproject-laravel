@extends('main._layouts.master')

<?php
    // {{ }} <--- cac ky tu dac biet se duoc thay the
    // {!! !!} <--- cac ky tu dac biet se khong thay the
    // {{-- --}} <--- comment code trong blade
    /**
     * section('scripts') <--- coi o? master.blade.php <--- no' la @yield('scripts')
     * section co' mo? la phai co' dong'
     * neu ma soan code php thi nen de? tren dau` de? no' load tuan tu chinh xac hon giong nhu code php nam tren section('scripts') vay ok roi
     * */
?>

@section('css')
    <link href="{{ asset('assets/css/components_datatables.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('js')    
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable_init.js') }}"></script>
@endsection

@section('content')
    <!-- Basic datatable -->
    <div class="card">
      
        <div class="card-header header-elements-inline">
        <h1 class="pt-3 pl-3 pr-3 font-weight-bold">Thông tin Bằng cấp</h1>
            <h4 class="card-title font-weight-bold text-uppercase">HR-Education</h4>

             <!-- Basic datatable -->
    
                <div class="ml-1">
                    <button id="register_leave" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter2">THÊM MỚI</button>
                </div>
     
              <!--End Basic datatable -->

            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="#" method="GET">

            </form>
        </div>

        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Mã ID</th>
                    <th>Mã Nhân viên</th>
                    <th>Bậc</th>
                    <th>Hạng Bậc</th>
                    <th>Tên Trường</th>
                    <th>Chuyên Ngành</th>
                    <th>Năm học</th>
                    <th>Xếp loại</th>
                    <th>Phương thức</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($data_education as $education)
                    <tr>
                        <td>{{ $education['id'] }}</td>
                        <td>{{ $education['staffId'] }}</td>
                        <td>{{ $education['level'] }}</td>
                        <td>{{ $education['levelName'] }}</td>
                        <td>{{ $education['school'] }}</td>
                        <td>{{ $education['fieldOfStudy'] }}</td>
                        <td>{{ $education['graduatedYear'] }}</td>
                        <td>{{ $education['grade'] }}</td>
                        <td>{{ $education['modeOfStudy'] }}</td>
                   
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    <!-- /basic datatable -->

     <!-- Modal Add Deparment -->
     <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{action('DepartmentController@CreateDepartment')}}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">THÊM MỚI</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Tên Phòng Ban</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" name="txtName"  required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Tên Phòng Ban Tiếng Việt</label>
                                <div class="col-lg-9">
                                <input type="text" class="form-control" name="txtName1"  required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>

    <!-- /basic datatable -->
@endsection

@section('scripts')
@endsection