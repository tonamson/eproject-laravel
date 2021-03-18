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
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Chi tiết hợp đồng</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Mã nhân viên</label>
                        <select class="form-control select-search" name="staffId" readonly>
                            @foreach($listStaff as $staff)
                                <option value="{{ $staff->id }}" @if($contract->staffId == $staff->id) selected @endif>{{ $staff->firstname .' '. $staff->lastname }}</option>
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
                                    <input type="text" class="form-control daterange-single" value="{{ $contract->startDate }}" name="startDate" readonly>
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
                                    <input type="text" class="form-control daterange-single" value="{{ $contract->endDate }}" name="endDate" readonly>
                                </div>
                            </div>
                        </div>
                        @php
                            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $contract->endDate);
                            $stopDate = \Carbon\Carbon::createFromFormat('Y-m-d', $contract->stopDate);
                        @endphp
                        @if($stopDate->lt($endDate))
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Chấm dứt hợp đồng trước kì hạn:</label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                        </span>
                                        <input type="text" class="form-control daterange-single" value="{{ $contract->endDate }}" name="endDate" readonly>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Lương:</label>
                        <input type="number" class="form-control" name="salary" value="{{ $contract->salary }}" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Các khoản phụ cấp</h5>
                </div>
                <div class="card-body" id="options">
                    <div class="row">
                        <div class="col-md-4">Tên</div>
                        <div class="col-md-4">Tính thuế</div>
                        <div class="col-md-4">Giá trị</div>
                    </div>
                    @foreach($contract->details as $index => $detail)
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="details[{{ $index }}][name]" class="form-control" value="{{ $detail->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="checkbox" name="details[{{ $index }}][is_tax]" class="form-control" {{ $detail->is_tax ? 'checked' : '' }} disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="number" name="details[{{ $index }}][price]" pattern="(^\d+\.?\d+$)|(^\d+%$)" class="form-control" value="{{ $detail->price }}" readonly>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/picker_date_init.js') }}"></script>
@endsection
