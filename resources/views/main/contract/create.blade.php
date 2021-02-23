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
@endsection

@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Danh sách hợp đồng</h5>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Mã hợp đồng:</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Mã nhân viên:</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ngày bắt đầu hợp đồng:</label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                        </span>
                                        <input type="text" class="form-control daterange-single" value="2021-01-01">
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
                                        <input type="text" class="form-control daterange-single" value="2021-01-01">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Lương:</label>
                            <input type="number" class="form-control">
                        </div>
                        <button class="btn btn-success" type="submit">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/picker_date_init.js') }}"></script>
@endsection
