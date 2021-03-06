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

    <script src="{{ asset('global_assets/js/plugins/ui/fullcalendar/core/main.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/ui/fullcalendar/daygrid/main.min.js') }}"></script>

@endsection

@section('content')
    <!-- Basic datatable -->
    <div class="card">
        <h1 class="pt-3 pl-3 pr-3">Lịch Sử Chấm Công</h1>
        <div class="card-header header-elements-inline">
            <h4 class="card-title font-weight-bold text-uppercase">
                <?php echo auth()->user()->firstname . " " . auth()->user()->lastname ?> 
                - <?php echo $staff[0][2] ?> 
                - <?php echo auth()->user()->is_manager == 1 ? 'Quản lý' : 'Nhân viên' ?>
            </h4>
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
                    <tr style="
                        <?php 
                            if($check_in_out['special_date_id'] !== null) echo "background-color: #fff2ce";
                            else if($check_in_out['day_of_week'] == 1 or $check_in_out['day_of_week'] == 7)  echo "background-color: #d3ffd4";
                        ?>
                    ">
                        <td>
                            ngày {{ $check_in_out['check_in_day'] }}, 
                            <?php 
                                if($check_in_out['day_of_week'] == 1) {
                                    echo 'Chủ Nhật';
                                } else {
                                    echo 'Thứ ' . $check_in_out['day_of_week'];
                                }
                            ?>
                            <?php 
                                if($check_in_out['special_date_id'] !== null) {
                                    echo '(Ngày lễ)';
                                }
                            ?>
                        </td>
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

    <!-- Event colors -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Xem lịch sử chấm công</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="fullcalendar-event-colors"></div>
        </div>
    </div>
    <!-- /event colors -->
@endsection

@section('scripts')
    <script>
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



        var FullCalendarStyling = function() {
            // External events
            var _componentFullCalendarStyling = function() {
                if (typeof FullCalendar == 'undefined') {
                    console.warn('Warning - Fullcalendar files are not loaded.');
                    return;
                }

                var eventColors = <?php echo $calendar ?>;

                var dt = new Date();
                let date_now = new Date().toISOString().split('T')[0];

                let month = <?php echo $month?> + '';
                if(month.length == 1) {
                    month = '0' + month;
                }
                
                date_now = '';
                date_now += <?php echo $year?> + '-' + month + '-01';

                // Define element
                var calendarEventColorsElement = document.querySelector('.fullcalendar-event-colors');

                // Initialize
                if(calendarEventColorsElement) {
                    var calendarEventColorsInit = new FullCalendar.Calendar(calendarEventColorsElement, {
                        plugins: [ 'dayGrid', 'interaction' ],
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,dayGridWeek,dayGridDay'
                        },
                        defaultDate: date_now,
                        editable: true,
                        events: eventColors
                    }).render();
                }

            };

            return {
                init: function() {
                    _componentFullCalendarStyling();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            FullCalendarStyling.init();
        });


    </script>
@endsection