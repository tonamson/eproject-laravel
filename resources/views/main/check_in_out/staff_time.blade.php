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
                        <input class="form-control" type="number" value="2021" name="year" id="year">
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
                    <th>Bổ sung</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $dat)
                {{-- @dd($data) --}}
                    <tr>
                        <td>{{ $dat['check_in_day'] }}</td>
                        <td>{{ $dat['check_in'] }}</td>
                        <td>{{ $dat['check_out'] }}</td>
                        <td>{{ $dat['time'] }}</td>
                        <td>{{ $dat['number_time'] }}</td>
                        <td class="text-center">
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Bổ sung công</a>
                                        <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Đăng kí phép</a>
                                    </div>
                                </div>
                            </div>
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
        /* ------------------------------------------------------------------------------
        *
        *  # Basic datatables
        *
        *  Demo JS code for datatable_basic.html page
        *
        * ---------------------------------------------------------------------------- */


        // Setup module
        // ------------------------------

        var DatatableBasic = function() {


            //
            // Setup module components
            //

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


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentDatatableBasic();
                    _componentSelect2();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            DatatableBasic.init();
        });

    </script>
@endsection