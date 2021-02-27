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
        <h1 class="pt-3 pl-3 pr-3 font-weight-bold">THÊM NHÂN VIÊN MỚI</h1>
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

            @if (\Session::has('message'))
                <div class="">
                    <div class="alert alert-danger">
                        {!! \Session::get('message') !!}
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
                            <input type="text" class="form-control" name="txtDepartment" value="{{$data['department']}}"> 
                        </div>
                        <div class="form-group">
                            <label>Phân Quyền:</label>
                            <select class="form-control" name="txtisManager" color="red" >
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
                            <select class="form-control" name="txtGender" color="red" >
                                <option value="1">Nam</option>
                                <option value="0">Nữ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Khu vực:</label>
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

        var DatatableBasic = function() {

            // Basic Datatable examples
            var _componentDatatableBasic = function() {
                if (!$().DataTable) {
                    console.warn('Warning - datatables.min.js is not loaded.');
                    return;
                }

                // Setting datatable defaults
                $.extend( $.fn.dataTable.defaults, {
                    autoWidth: false,
                    columnDefs: [{ 
                        orderable: false,
                        width: 100,
                        targets: [ 5 ]
                    }],
                    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                    language: {
                        search: '<span>Filter:</span> _INPUT_',
                        searchPlaceholder: 'Type to filter...',
                        lengthMenu: '<span>Show:</span> _MENU_',
                        paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                    }
                });

                // Basic datatable
                $('.datatable-basic').DataTable();
                $('.datatable-basic2').DataTable();

                // Alternative pagination
                $('.datatable-pagination').DataTable({
                    pagingType: "simple",
                    language: {
                        paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
                    }
                });

                // Datatable with saving state
                $('.datatable-save-state').DataTable({
                    stateSave: true
                });

                // Scrollable datatable
                var table = $('.datatable-scroll-y').DataTable({
                    autoWidth: true,
                    scrollY: 300
                });

                // Resize scrollable table when sidebar width changes
                $('.sidebar-control').on('click', function() {
                    table.columns.adjust().draw();
                });
            };

            // Select2 for length menu styling
            var _componentSelect2 = function() {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }

                // Initialize
                $('.dataTables_length select').select2({
                    minimumResultsForSearch: Infinity,
                    dropdownAutoWidth: true,
                    width: 'auto'
                });
            };

            return {
                init: function() {
                    _componentDatatableBasic();
                    _componentSelect2();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            DatatableBasic.init();
        });

});






    </script>



@endsection