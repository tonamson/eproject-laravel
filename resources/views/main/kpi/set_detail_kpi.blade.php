@extends('main._layouts.master')

<?php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
?>

@section('css')
    <link href="{{ asset('assets/css/components_datatables.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        .border-red {
            border-color: red !important;
        }

        .list-icons-item-remove::after {
            cursor: pointer;
            content: "";
            font-size: .8125rem;
            font-family: icomoon;
            font-size: 1rem;
            min-width: 1rem;
            text-align: center;
            display: inline-block;
            vertical-align: middle;
            -webkit-font-smoothing: antialiased;
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
                @if ($create_success)
                    <div class="pt-3 pl-3 pr-3">
                        <div class="alert alert-success">
                            {{ $create_success }}
                        </div>
                    </div>
                @endif

                @if (\Session::has('success'))
                    <div class="pt-3 pl-3 pr-3">
                        <div class="alert alert-success">
                            {!! \Session::get('success') !!}
                        </div>
                    </div>
                @endif
            
                @if (\Session::has('error'))
                    <div class="pt-3 pl-3 pr-3">
                        <div class="alert alert-danger">
                            {!! \Session::get('error') !!}
                        </div>
                    </div>
                @endif

                @if(!$readonly)
                    <div class="card-body">
                        <div class="form-group">
                            <div class="float-left">
                                <button id="btn_add_more" class="btn btn-info">Thêm Công Việc</button>
                            </div>
                            <div class="float-right">
                                <button id="btn_submit_form" class="btn btn-success">Lưu</button>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
    <form action="{{ action('KpiController@createKpi') }}" method="POST" id="form_detail_kpi">
        @csrf
        <input type="hidden" name="department_id" value="{{ $department_id }}">
        <input type="hidden" name="kpi_name" value="{{ $kpi_name }}">
        <input type="hidden" name="kpi_id" value="{{ $kpi_id }}">
        <input type="hidden" name="staff_id" value="{{ $staff_id }}">
        <div class="row" id="row_kpi_detail">
            <?php $count = 1; ?>
            @foreach ($kpi_details as $kpi_detail)
                <input type="hidden" name="kpi_detail_id[]" value="{{ $kpi_detail['id'] }}">
                <input id="input_del<?php echo $count ?>" type="hidden" name="del[]" value="false">
                <div class="col-md-6 one_row" id="one_row<?php echo $count ?>">
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h6 class="card-title">Công việc <?php echo $count ?></h6>
                            <div class="header-elements">
                                <div class="list-icons">
                                    @if(!$readonly)
                                        <a class="list-icons-item list-icons-item-remove" onclick="removeTask(<?php echo $count ?>)" ></a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-4">Mục tiêu Công việc:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control target" name="target[]" value="{{ $kpi_detail['taskTarget'] }}" placeholder="Vd: Tăng tỉ lệ chuyển đổi bán hàng của website lên 20%" <?php echo $readonly ? 'readonly' : 'required' ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-4">Chi tiết Công việc:</label>
                                <div class="col-lg-8">
                                    <textarea rows="3" cols="3" class="form-control task_description" name="task_description[]" placeholder="Vd: Tỷ lệ chuyển đổi hiện tại của website đang bị chững lại ở ngưỡng 12%, để có thể cạnh tranh được với những đối thủ cùng phân khúc, doanh nghiệp phải tìm cách để tối ưu chúng lên 20% trong 6 tháng" <?php echo $readonly ? 'readonly' : 'required' ?>>{{ $kpi_detail['taskDescription'] }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-4">Các bước thực hiện:</label>
                                <div class="col-lg-8">
                                    <textarea rows="3" cols="3" class="form-control duties_activities" name="duties_activities[]" placeholder="Vd: Tìm hiểu thị trường, chạy marketing, ..." <?php echo $readonly ? 'readonly' : 'required' ?>>{{ $kpi_detail['dutiesActivities'] }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-4">Các kĩ năng cần có:</label>
                                <div class="col-lg-8">
                                    <textarea rows="3" cols="3" class="form-control skill" name="skill[]" placeholder="Vd: Tìm kiếm thông tin, ..." <?php echo $readonly ? 'readonly' : 'required' ?>>{{ $kpi_detail['skill'] }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-4">Tỉ lệ trên tổng các Công việc:</label>
                                <div class="col-lg-8">
                                    <input id="ratio<?php echo $count ?>" type="number" name="ratio[]" class="form-control ratio" min="0" max="100" value="{{ $kpi_detail['ratio'] }}" placeholder="Vd: 20" <?php echo $readonly ? 'readonly' : 'required' ?>>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <?php $count++ ?>
            @endforeach   
            
        </div>
    </form>

@endsection

@section('scripts')
    <script>
        $('.day_leave').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

        function removeTask(row_number) {
            if(confirm("Bạn có chắc chắn muốn xóa Công việc này?")){
                document.getElementById("one_row"+row_number).style.display = "none";
                document.getElementById("input_del"+row_number).value = 'true';
                document.getElementById("ratio"+row_number).value = '0';
                return true;
            } else {
                return false;
            }
        }

        function checkEmpty(e) {
            if(e.value) {
                e.classList.remove('border-red');
            }else {
                e.classList.add('border-red');
            }
        }

        $( document ).ready(function() {
            var count_job = <?php echo $count ?>;
            $("#btn_add_more").click(function() {
                html = '<div class="col-md-6" id="one_row<?php echo $count ?>"><input id="input_del<?php echo $count ?>" type="hidden" name="del[]" value="false"><div class="card"><div class="card-header header-elements-inline"><h6 class="card-title">Công việc '+count_job+'</h6><div class="header-elements"><div class="list-icons"><a class="list-icons-item list-icons-item-remove"  onclick="removeTask(<?php echo $count ?>)"></a></div></div></div>'
                html += '<div class="card-body">';
                html += '<div class="form-group row"><label class="col-form-label col-lg-4">Mục tiêu Công việc:</label><div class="col-lg-8"><input type="text" class="form-control target" onkeyup=checkEmpty(this) name="target[]" placeholder="Vd: Tăng tỉ lệ chuyển đổi bán hàng của website lên 20%" required></div></div>';
                html += '<div class="form-group row"><label class="col-form-label col-lg-4">Chi tiết Công việc:</label><div class="col-lg-8"><textarea rows="3" cols="3" class="form-control task_description" onkeyup=checkEmpty(this) name="task_description[]" placeholder="Vd: Tỷ lệ chuyển đổi hiện tại của website đang bị chững lại ở ngưỡng 12%, để có thể cạnh tranh được với những đối thủ cùng phân khúc, doanh nghiệp phải tìm cách để tối ưu chúng lên 20% trong 6 tháng" required></textarea></div></div>';
                html += '<div class="form-group row"><label class="col-form-label col-lg-4">Các bước thực hiện:</label><div class="col-lg-8"><textarea rows="3" cols="3" class="form-control duties_activities" onkeyup=checkEmpty(this) name="duties_activities[]" placeholder="Vd: Tìm hiểu thị trường, chạy marketing, ..." required></textarea></div></div>';
                html += '<div class="form-group row"><label class="col-form-label col-lg-4">Các kĩ năng cần có:</label><div class="col-lg-8"><textarea rows="3" cols="3" class="form-control skill" onkeyup=checkEmpty(this) name="skill[]" placeholder="Vd: Tìm kiếm thông tin, ..." required></textarea></div></div>';
                html += '<div class="form-group row"><label class="col-form-label col-lg-4">Tỉ lệ trên tổng các Công việc:</label><div class="col-lg-8"><input type="number" name="ratio[]" class="form-control ratio" onkeyup=checkEmpty(this) min="0" max="100" placeholder="Vd: 20" required></div></div>';
                html += '</div></div></div>';
                $("#row_kpi_detail").append(html);
                count_job++;

            });

            $("#btn_submit_form").click(function() {
                $("#form_detail_kpi").submit();
            });

            $("#form_detail_kpi").submit(function() {
                //Check target        
                var target = $('.target').map(function() {
                    return $(this).val();
                });

                for(let i = 0; i < target.length; i++) {
                    if(!target[i]) {
                        alert("Mục tiêu Công việc không được để trống");
                        $('.target:eq('+i+')').addClass('border-red');
                        $('.target:eq('+i+')').focus();
                        return false;
                    }
                }

                //Check task_description        
                var task_description = $('.task_description').map(function() {
                    return $(this).val();
                });

                for(let i = 0; i < task_description.length; i++) {
                    if(!task_description[i]) {
                        alert("Chi tiết Công việc không được để trống");
                        $('.task_description:eq('+i+')').addClass('border-red');
                        $('.task_description:eq('+i+')').focus();
                        return false;
                    }
                }

                //Check duties_activities        
                var duties_activities = $('.duties_activities').map(function() {
                    return $(this).val();
                });

                for(let i = 0; i < duties_activities.length; i++) {
                    if(!duties_activities[i]) {
                        alert("Các bước thực hiện không được để trống");
                        $('.duties_activities:eq('+i+')').addClass('border-red');
                        $('.duties_activities:eq('+i+')').focus();
                        return false;
                    }
                }

                //Check skill        
                var skill = $('.skill').map(function() {
                    return $(this).val();
                });

                for(let i = 0; i < skill.length; i++) {
                    if(!skill[i]) {
                        alert("Các kĩ năng cần có không được để trống");
                        $('.skill:eq('+i+')').addClass('border-red');
                        $('.skill:eq('+i+')').focus();
                        return false;
                    }
                }

                //Check ratio        
                var ratio = $('.ratio').map(function() {
                    return $(this).val();
                });

                for(let i = 0; i < ratio.length; i++) {
                    if(!ratio[i]) {
                        alert("Tỉ lệ không được để trống");
                        $('.ratio:eq('+i+')').addClass('border-red');
                        $('.ratio:eq('+i+')').focus();
                        return false;
                    }
                }


                //Check ratio 100
                var ratio = $('.ratio').map(function() {
                    return $(this).val();
                });

                let total_ratio = 0;
                for (let val of ratio) {
                    total_ratio += Number(val);
                }

                if(total_ratio !== 100) {
                    alert("Tổng tỉ lệ của các Công việc phải bằng 100");
                    return false;
                }

            });
                    
        });

    </script>
@endsection