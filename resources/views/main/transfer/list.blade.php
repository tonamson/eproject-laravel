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
    </style>
@endsection

@section('js')    
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/anytime.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2_init.js') }}"></script>
@endsection

@section('content')
    <!-- Basic datatable -->
    <div class="card">
        <h1 class="pt-3 pl-3 pr-3">Danh Sách Nhân Viên Điều Chuyển Phòng Ban</h1>
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
            <form action="{{ action('TransferController@list') }}" method="GET">
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
            
            @if(auth()->user()->department == 2)
                <div class="form-group d-flex">
                    <div class="">
                        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">Tạo mới</button>
                    </div>
                </div>
            @endif
        </div>
        <!-- Modal bsc -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ action('TransferController@create') }}" method="post">
                        @csrf
                        <input type="hidden" name="id_staff_create" value="{{ auth()->user()->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Tạo Điều Chuyển Mới</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Tên nhân viên</label>
                                <div class="col-lg-9">
                                    <select class="form-control select-search select_staff_transfer" name="staff_id" id="selected_staff">
                                        <option value="">Chọn nhân viên</option>
                                        @foreach($listStaff as $staff)
                                            <option value="{{ $staff->id }}" old_department="{{ $staff->department }}">{{ $staff->firstname .' '. $staff->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Phòng ban hiện tại:</label>
                                <div class="col-lg-9">
                                    <select class="form-control old_department" name="old_department" readonly="true">

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Phòng ban điều chuyển:</label>
                                <div class="col-lg-9">
                                    <select class="form-control new_department" name="new_department">
                                        @foreach($listDepartment as $department)
                                            <option value="{{ $department["id"] }}" >{{ $department["name"] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Ghi chú:</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="note" id="note" cols="20" rows="10" placeholder="VD: Quản lý yêu cầu, ..." required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Tạo mới</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>

        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên nhân viên</th>
                    <th>Phòng ban hiện tại</th>
                    <th>Phòng ban điều chuyển</th>
                    <th>Quản lý phòng ban hiện tại phê duyệt</th>
                    <th>Quản lý phòng ban điều chuyển phê duyệt</th>
                    <th>Ghi chú</th>
                    <th>Ngày tạo</th>
                    <th class="text-center">Sửa / Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; ?>
                @foreach ($data as $transfer)
                     <tr>
                        <td><?php echo $count; $count++ ?></td>
                        <td><?php echo $transfer['staff_transfer'] ?></td>
                        <td><?php echo $transfer['old_department_name'] ?></td>
                        <td><?php echo $transfer['new_department_name'] ?></td>
                        <td>
                            <?php echo $transfer['old_manager_approved'] == 0 ? '<span class="badge badge-warning">Chưa phê duyệt</span>' : '<span class="badge badge-success">Đã phê duyệt</span>' ?>
                        </td>
                        <td>
                            <?php echo $transfer['new_manager_approved'] == 0 ? '<span class="badge badge-warning">Chưa phê duyệt</span>' : '<span class="badge badge-success">Đã phê duyệt</span>' ?>
                        </td>
                        <td style="max-width: 160px;"> 
                            <?php 
                                if(strlen($transfer['note']) > 40) echo substr($transfer['note'], 0, 40) . '...';
                                else echo $transfer['note'];
                            ?>
                        </td>
                        <td><?php echo $transfer['created_at'] ?></td>
                        @if(auth()->user()->department == 2)
                            @if($transfer['old_manager_approved'] == 0 && $transfer['new_manager_approved'] == 0)
                                <td>
                                    <div class="from-group d-flex">
                                        <a class="btn btn-info open-detail-transfer" id="{{ $transfer['id'] }}" style="color: white; cursor: pointer;">Sửa</a>
                                        <a href="{{ action('TransferController@delete') }}?id={{ $transfer['id'] }}" class="btn btn-danger ml-2" style="color: white; cursor: pointer;">Xóa</a>
                                    </div>
                                    @if(auth()->user()->is_manager == 1)
                                        <a href="{{ action('TransferController@approve') }}?id={{ $transfer['id'] }}" class="btn btn-primary ml-2" style="color: white; cursor: pointer;">Phê duyệt</a>
                                    @endif
                                </td>
                            @elseif($transfer['old_manager_approved'] == 1 && $transfer['new_manager_approved'] == 1)
                                <td style="max-width: 160px;">Đã phê duyệt, nhân viên đã chuyển phòng ban</td>
                            @else
                                @if(auth()->user()->is_manager == 1)
                                    <td>
                                        <div class="from-group d-flex">
                                            <a href="{{ action('TransferController@approve') }}?id={{ $transfer['id'] }}" class="btn btn-primary ml-2" style="color: white; cursor: pointer;">Phê duyệt</a>
                                        </div>
                                    </td>
                                @else
                                    <td style="max-width: 160px;">Đã có ít nhất một quản lý phê duyệt, không thể chỉnh sửa</td>
                                @endif
                            @endif
                        @else
                            <td>
                                <div class="from-group d-flex">
                                    <a href="{{ action('TransferController@approve') }}?id={{ $transfer['id'] }}" class="btn btn-primary ml-2" style="color: white; cursor: pointer;">Phê duyệt</a>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach   
            </tbody>
        </table>

        <div id="bsc-modal" class="modal fade" role="dialog"> <!-- modal bsc -->
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ action('TransferController@update') }}" method="post" class="form-horizontal">
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
        $( document ).ready(function() {
            $('.open-detail-transfer').click(function() {
                var id = $(this).attr('id');

                $.ajax({
                    url: '{{ action('TransferController@detail') }}',
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

            $( ".select_staff_transfer" ).change(function() {
                var old_department = $('option:selected', this).attr('old_department');

                $.ajax({
                    url: '{{ action('TransferController@loadOldDepartment') }}',
                    Type: 'GET',
                    datatype: 'text',
                    data:
                    {
                        old_department: old_department
                    },
                    cache: false,
                    success: function (data)
                    {
                        $('.old_department').empty().append(data);
                    }
                });

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

        

    </script>
@endsection