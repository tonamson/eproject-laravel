@extends('main._layouts.master')

<?php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
?>

@section('css')
    <link href="{{ asset('assets/css/components_datatables.min.css') }}" rel="stylesheet" type="text/css">
    <style>

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
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <h1 class="pt-3 pl-3 pr-3">
                    Thiết Lập KPI 
                    - {{ $kpi_name }}
                    <?php 
                        if($staff_id !== null) echo "- " . auth()->user()->firstname . ' ' . auth()->user()->lastname;
                        else if($department_id !== null) echo "- " . auth()->user()->department;
                    ?>
                </h1>
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
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('.day_leave').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

        $( document ).ready(function() {
                    
            $( "#select_kpi" ).change(function() {
                var select_kpi = $(this).val();
                var staff_id = {{ auth()->user()->id }}

                $.ajax({
                    url: '{{ action('KpiController@findKpiStaff') }}',
                    Type: 'GET',
                    datatype: 'text',
                    data:
                    {
                        staff_id: staff_id,
                        kpi_name: select_kpi
                    },
                    cache: false,
                    success: function (data)
                    {
                        $('#html_pending_staff').empty().append(data);
                    }
                });

            }); 

            $( "#select_kpi_department" ).change(function() {
                var select_kpi_department = $(this).val();
                var department_id = {{ auth()->user()->department }}

                $.ajax({
                    url: '{{ action('KpiController@findKpiDepartment') }}',
                    Type: 'GET',
                    datatype: 'text',
                    data:
                    {
                        department_id: department_id,
                        kpi_name: select_kpi_department
                    },
                    cache: false,
                    success: function (data)
                    {
                        $('#html_pending_department').empty().append(data);
                    }
                });

            }); 
        });

    </script>
@endsection