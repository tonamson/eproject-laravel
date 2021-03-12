@extends('main._layouts.master')

@section('css')
@endsection

@section('js')
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
    <form action="{{ route('postSaveContract') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Tạo mới hợp đồng</h5>
                    </div>
                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-{{ session('message')['type'] }} border-0 alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                {{ session('message')['message'] }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Mã nhân viên</label>
                            <select class="form-control select-search" name="staffId">
                                @foreach($listStaff as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->firstname .' '. $staff->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ngày bắt đầu hợp đồng:</label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                        </span>
                                        <input type="text" class="form-control daterange-single" value="2021-01-01" name="startDate">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ngày kết thúc hợp đồng:</label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                        </span>
                                        <input type="text" class="form-control daterange-single" value="2021-01-01" name="endDate">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tổng lương:</label>
                            <input type="number" class="form-control" name="salary" value="0" readonly>
                        </div>
                        <button class="btn btn-success" type="submit">Lưu</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Chi tiết hợp đồng</h5>
                        <div class="header-elements">
                            <a href="javascript:void(0)" onclick="addOption()" class="text-default"><i title="Thêm chi tiết" class="icon-stack-plus "></i></a>
                        </div>
                    </div>
                    <div class="card-body" id="options">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tên</label>
                                    <input type="text" name="details[0][name]" class="form-control" value="Lương cơ bản">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Giá</label>
                                    <input type="number" onkeyup="changeDetailContract()" name="details[0][price]" pattern="(^\d+\.?\d+$)|(^\d+%$)" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tên</label>
                                    <input type="text" name="details[1][name]" class="form-control" value="Tiền đi lại">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Giá</label>
                                    <input type="number" onkeyup="changeDetailContract()" name="details[1][price]" pattern="(^\d+\.?\d+$)|(^\d+%$)" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tên</label>
                                    <input type="text" name="details[2][name]" class="form-control" value="Phí gửi xe">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Giá</label>
                                    <input type="number" onkeyup="changeDetailContract()" name="details[2][price]" pattern="(^\d+\.?\d+$)|(^\d+%$)" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/picker_date_init.js') }}"></script>
    <script>
        let optionIndex = 2;

        function addOption() {
            optionIndex++;
            $('#options').append(`
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên</label>
                                <input type="text" name="details[${optionIndex}][name]" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Giá</label>
                                <input type="number" onkeypress="changeDetailContract()" name="details[${optionIndex}][price]" pattern="(^\d+\.?\d+$)|(^\d+%$)" class="form-control" value="0">
                            </div>
                        </div>
                    </div>
            `);
        }

        function changeDetailContract() {
            let total_salary = 0;
            $('input[type="number"][name^="details"]').each((index, item) => {
                total_salary += Number(item.value);
            });
            $('input[type="number"][name="salary"]').val(total_salary);
        }
    </script>
@endsection
