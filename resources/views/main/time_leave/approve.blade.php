@extends('main._layouts.master')

<?php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
?>

@section('css')
    <link href="{{ asset('assets/css/components_datatables.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('js')    
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/notifications/jgrowl.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/picker_date.js') }}"></script>
@endsection

@section('content')
    <!-- Basic datatable -->
    <div class="card">
        @if(auth()->user()->department == 2 && auth()->user()->is_manager == 1)
            <h1 class="pt-3 pl-3 pr-3">Duyệt Công Phép</h1>
        @elseif(auth()->user()->department == 2)
            <h1 class="pt-3 pl-3 pr-3">Duyệt Phép</h1>
        @else
            <h1 class="pt-3 pl-3 pr-3">Duyệt Bổ Sung Công</h1>
        @endif

        <div class="card-header header-elements-inline">
            <h4 class="card-title font-weight-bold text-uppercase">
                <?php echo auth()->user()->firstname . " " . auth()->user()->lastname ?> 
                - <?php echo $staff[0][2] ?> 
                - <?php echo auth()->user()->is_manager == 1 ? 'Quản lý' : 'Nhân viên' ?>
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
            <form action="{{ action('TimeleaveController@approveTimeLeave') }}" method="GET">
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

            @if(auth()->user()->department == 2 && auth()->user()->is_manager == 1)
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                    <button class="nav-link active" id="btn_tb_bsc">Bổ sung công</button>
                    <li class="nav-item">
                    <button class="nav-link" id="btn_tb_dkp">Đăng kí phép</button>
                    </li>
                </ul>
            @endif
        </div>

        <table class="table datatable-basic" id="tb_bsc">
            <thead>
                <tr>
                    <th>Tên nhân viên</th>
                    <th>Phòng ban</th>
                    <th>Ngày </th>
                    <th>Ngày công</th>
                    <th>Ghi chú</th>
                    <th>Phê duyệt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $time_leave)
                    @if($time_leave['type'] == 0)
                        <tr>
                            <td>{{ $time_leave['firstname'] . ' ' . $time_leave['lastname'] }}</td>
                            <td>{{ $time_leave['name'] }}</td>
                            <td>{{ $time_leave['day_time_leave'] }}</td>
                            <td><?php echo $time_leave['time'] == "08:00:00" ? '1 ngày công' : '0.5 ngày công' ?></td>
                            <td>
                                <?php 
                                    if(strlen($time_leave['note']) > 20) echo substr($time_leave['note'], 0, 30) . '...';
                                    else echo $time_leave['note'];    
                                ?>
                            </td>
                            <td>
                                <?php echo $time_leave['is_approved'] == 0 ? '<span class="badge badge-warning">Chưa phê duyệt</span>' : '<span class="badge badge-success">Đã phê duyệt</span>' ?>
                            </td>
                            <td>
                                <div class="from-group d-flex">
                                    <a class="btn btn-info open-detail-time-leave" id="{{ $time_leave['id'] }}" style="color: white; cursor: pointer;">Chi tiết</a>
                                </div>
                            </td>
                            {{-- @if($time_leave['is_approved'] == 0)
                                <td>
                                    <div class="from-group d-flex">
                                        <a class="btn btn-info open-detail-time-leave" id="{{ $time_leave['id'] }}" style="color: white; cursor: pointer;">Sửa</a>
                                        <a href="{{ action('TimeleaveController@deleteTime') }}?id={{ $time_leave['id'] }}" class="btn btn-danger ml-2" style="color: white; cursor: pointer;">Xóa</a>
                                    </div>
                                </td>
                            @else
                                <td>Quản lý đã phê duyệt, không thể chỉnh sửa!</td>
                            @endif --}}
                        </tr>                        
                    @endif
                @endforeach       
            </tbody>
        </table>

        <table class="table datatable-basic2" id="tb_dkp">
             <thead>
                <tr>
                    <th>Tên nhân viên</th>
                    <th>Phòng ban</th>
                    <th>Ngày </th>
                    <th>Ngày công</th>
                    <th>Ghi chú</th>
                    <th>Phê duyệt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $time_leave)
                    @if($time_leave['type'] == 1)
                        <tr>
                            <td>{{ $time_leave['firstname'] . ' ' . $time_leave['lastname'] }}</td>
                            <td>{{ $time_leave['name'] }}</td>
                            <td>{{ $time_leave['day_time_leave'] }}</td>
                            <td><?php echo $time_leave['time'] == "08:00:00" ? '1 ngày công' : '0.5 ngày công' ?></td>
                            <td>
                                <?php 
                                    if(strlen($time_leave['note']) > 20) echo substr($time_leave['note'], 0, 30) . '...';
                                    else echo $time_leave['note'];    
                                ?>
                            </td>
                            <td>
                                <?php echo $time_leave['is_approved'] == 0 ? '<span class="badge badge-warning">Chưa phê duyệt</span>' : '<span class="badge badge-success">Đã phê duyệt</span>' ?>
                            </td>
                            <td>
                                <div class="from-group d-flex">
                                    <a class="btn btn-info open-detail-time-leave" id="{{ $time_leave['id'] }}" style="color: white; cursor: pointer;">Chi tiết</a>
                                </div>
                            </td>
                        </tr>                        
                    @endif
                @endforeach       
            </tbody>
        </table>

        <?php if(auth()->user()->department == 2 && auth()->user()->is_manager == 0):?>
            <style>
                #tb_bsc_wrapper {
                    display: none;
                }
            </style>
        <?php else :?>
            <style>
                #tb_dkp_wrapper {
                    display: none;
                }
            </style>
        <?php endif ?>

        <div id="bsc-modal" class="modal fade" role="dialog"> <!-- modal bsc -->
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ action('TimeleaveController@approvedTimeLeave') }}" method="post" class="form-horizontal">
                    @csrf
                    <div id="html_pending">
                        
                    </div>
                </form> <!-- end form -->
              </div>
            </div>
        </div> <!-- end modal bsc -->
          
    </div>
    <!-- /basic datatable -->
@endsection

@section('scripts')
    <script>

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
                url: '{{ action('TimeleaveController@detailStaffApprove') }}',
                Type: 'GET',
                datatype: 'html',
                data:
                {
                    id: id,
                },
                cache: false,
                success: function (data)
                {
                    $('#html_pending').empty().append(data);
                    $('#bsc-modal').modal();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
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
                        search: '<span>Tìm kiếm:</span> _INPUT_',
                        searchPlaceholder: 'Nhập để tìm kiếm...',
                        lengthMenu: '<span>Hiển thị:</span> _MENU_',
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

    </script>
@endsection