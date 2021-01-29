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
   
@endsection

@section('js')
    <script></script>
@endsection

@section('content')

    <!-- Content area -->
    <div class="content">

        <!-- Pies -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Độ Tuổi</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                                <a class="list-icons-item" data-action="reload"></a>
                                <a class="list-icons-item" data-action="remove"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="chart-container text-center">
                            <div class="d-inline-block" id="c3-pie-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Giới Tính</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                                <a class="list-icons-item" data-action="reload"></a>
                                <a class="list-icons-item" data-action="remove"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="chart-container text-center">
                            <div class="d-inline-block" id="c3-donut-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /pies -->

        <div class="content pt-0">
            <!-- Axis tick rotation -->
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Tăng Trưởng</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart" id="c3-axis-tick-rotation"></div>
                    </div>
                </div>
            </div>
            <!-- /axis tick rotation -->
        </div>

    </div>
    <!-- /content area -->


@endsection

@section('scripts')
<script>    
    var С3BarsPies = function() {
        // Chart
        var _barsPiesExamples = function() {
            if (typeof c3 == 'undefined') {
                console.warn('Warning - c3.min.js is not loaded.');
                return;
            }
        
            // Define charts elements
            var pie_chart_element = document.getElementById('c3-pie-chart');
            var donut_chart_element = document.getElementById('c3-donut-chart');
            var bar_chart_element = document.getElementById('c3-bar-chart');
            var bar_stacked_chart_element = document.getElementById('c3-bar-stacked-chart');
            var combined_chart_element = document.getElementById('c3-combined-chart');
            var scatter_chart_element = document.getElementById('c3-scatter-chart');
            var sidebarToggle = document.querySelector('.sidebar-control');
        
        
            // Pie chart
            if(pie_chart_element) {
                let staffs_age = {!! $staffs_age !!};

                let arr_staffs_age = Object.entries(staffs_age);
                arr_staffs_age[0][0] = "18-25 Tuổi";
                arr_staffs_age[1][0] = "25-35 Tuổi";
                arr_staffs_age[2][0] = "35-45 Tuổi";
                arr_staffs_age[3][0] = "45-55 Tuổi";
                arr_staffs_age[4][0] = "Khác";

                // Generate chart
                var pie_chart = c3.generate({
                    bindto: pie_chart_element,
                    size: { width: 350 },
                    color: {
                        pattern: ['#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80']
                    },
                    data: {
                        columns: [
                            arr_staffs_age[0],
                            arr_staffs_age[1],
                            arr_staffs_age[2],
                            arr_staffs_age[3],
                            arr_staffs_age[4]
                        ],
                        type : 'pie'
                    }
                });
        
                // Resize chart on sidebar width change
                sidebarToggle && sidebarToggle.addEventListener('click', function() {
                    pie_chart.resize();
                });
            }
        
            // Donut chart
            if(donut_chart_element) {
                let staffs_gender = {!! $staffs_gender !!};

                let arr_staffs_gender = Object.entries(staffs_gender);    

                // Generate chart
                var donut_chart = c3.generate({
                    bindto: donut_chart_element,
                    size: { width: 350 },
                    color: {
                        pattern: ['#2ec7c9','#b6a2de']
                    },
                    data: {
                        columns: [
                            arr_staffs_gender[0],
                            arr_staffs_gender[1],
                        ],
                        type : 'donut'
                    },
                    donut: {
                        title: "Tỉ lệ Nam / Nữ"
                    }
                });
        
                // Resize chart on sidebar width change
                sidebarToggle && sidebarToggle.addEventListener('click', function() {
                    donut_chart.resize();
                });
            }
        };
        
        return {
            init: function() {
                _barsPiesExamples();
            }
        }
    }();

    var С3Axis = function() {

        // Chart
        var _axisExamples = function() {
            if (typeof c3 == 'undefined') {
                console.warn('Warning - c3.min.js is not loaded.');
                return;
            }

            // Define charts elements
            var axis_tick_rotation_element = document.getElementById('c3-axis-tick-rotation');
            var sidebarToggle = document.querySelector('.sidebar-control');

            // Text label rotation
            if(axis_tick_rotation_element) {

                // Generate chart
                var axis_tick_rotation = c3.generate({
                    bindto: axis_tick_rotation_element,
                    size: { height: 400 },
                    data: {
                        x : 'x',
                        columns: [
                            ['x', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                            ['pv', 90, 100, 140, 200, 100, 400, 90, 100, 140, 200, 100, 400],
                        ],
                        type: 'bar'
                    },
                    color: {
                        pattern: ['#5ab1ef']
                    },
                    axis: {
                        x: {
                            type: 'category',
                            tick: {
                                rotate: -90
                            },
                            height: 80
                        }
                    },
                    grid: {
                        x: {
                            show: true
                        }
                    }
                });

                // Resize chart on sidebar width change
                sidebarToggle && sidebarToggle.addEventListener('click', function() {
                    axis_tick_rotation.resize();
                });
            }
        };

        return {
            init: function() {
                _axisExamples();
            }
        }
    }();

    document.addEventListener('DOMContentLoaded', function() {
        С3Axis.init();
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        С3BarsPies.init();
    });
        
</script>
@endsection