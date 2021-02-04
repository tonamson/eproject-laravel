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
        <h1 class="pt-3 pl-3 pr-3">Công Phép</h1>
        <div class="card-header header-elements-inline">
            <h4 class="card-title font-weight-bold text-uppercase">Nguyễn Ngọc Anh Tâm - HR - Staff</h4>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
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
            <form action="{{ action('CheckInOutController@show') }}" method="GET">
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

            <div class="form-group d-flex">
                <div class="">
                    <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">Bổ Sung Công</button>
                </div>
                <div class="ml-1">
                    <button id="register_leave" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter2">Đăng Kí Phép</button>
                </div>
            </div>
        </div>
        <!-- Modal bsc -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ action('TimeleaveController@createTime') }}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Bổ Sung Công</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Ngày bổ sung:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control day_leave" name="day_leave" value="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Yêu cầu điều chỉnh:</label>
                                <div class="col-lg-9">
                                    <select class="form-control" name="number_day_leave" id="number_day_leave">
                                        <option value="1">Một ngày</option>
                                        <option value="0.5">Nửa ngày</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Lý do:</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="note_bsc" id="note_bsc" cols="20" rows="10" placeholder="VD: Quên check in, Quên check out, ..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>

        <!-- Modal bsc -->
        <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle2" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Đăng Kí Phép</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Ngày đăng kí phép:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control day_bsc" name="day_bsc" value="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Công đăng kí phép:</label>
                                <div class="col-lg-9">
                                    <select class="form-control" name="number_day_bsc" id="number_day_bsc">
                                        <option value="1">Một ngày công</option>
                                        <option value="0.5">Nửa ngày công</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Lý do nghỉ phép:</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="note_leave" id="note_leave" cols="20" rows="10" placeholder="VD: Bận việc gia đình, khám bệnh, ..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>

        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Giờ vào</th>
                    <th>Giờ ra</th>
                    <th>Tổng thời gian làm việc</th>
                    <th>Ngày công</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $check_in_out)
                {{-- @dd($data) --}}
                    <tr>
                        <td>{{ $check_in_out['check_in_day'] }}</td>
                        <td>{{ $check_in_out['check_in'] }}</td>
                        <td>{{ $check_in_out['check_out'] }}</td>
                        <td>{{ $check_in_out['time'] }}</td>
                        <td>{{ $check_in_out['number_time'] }}</td>
                        <td style="min-width: 220px">
                            <?php
                                if($check_in_out['in_late']){
                                    $date = date_create($check_in_out['in_late']);
                                    echo 'Đi trễ: ' . date_format($date,"H") . ' giờ';
                                    echo ' ' . date_format($date,"i") . ' phút';
                                    echo ' ' . date_format($date,"s") . ' giây';
                                    echo "<br>";
                                }
                                if($check_in_out['out_soon']){
                                    $date = date_create($check_in_out['out_soon']);
                                    echo 'Về sớm: ' . date_format($date,"H") . ' giờ';
                                    echo ' ' . date_format($date,"i") . ' phút';
                                    echo ' ' . date_format($date,"s") . ' giây';
                                    echo "<br>";
                                }
                                if($check_in_out['ot']){
                                    $date = date_create($check_in_out['ot']);
                                    echo 'Tăng ca: ' . date_format($date,"H") . ' giờ';
                                    echo ' ' . date_format($date,"i") . ' phút';
                                    echo ' ' . date_format($date,"s") . ' giây';
                                    echo "<br>";
                                }
                            ?>
                        </td>
                    </tr>
                @endforeach       
            </tbody>
        </table>
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

        $(document).ready(function(){
            $('#register_leave').click(function(){
                var request = new Request('http://localhost:8888/staff/updateDayOfLeave');

                fetch(request, {mode: 'no-cors'}).then(function(response) {
                    return response.json();
                }).then(function(j) {
                    console.log(JSON.stringify(j));
                }).catch(function(error) {
                    console.log('Request failed', error)
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