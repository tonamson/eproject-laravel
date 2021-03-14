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

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Chi tiết bảng tính lương</h5>
        </div>
        <div class="card-body">
            <table class="table datatable-basics">
                <thead>
                <tr>
                    <th>Mã nhân viên</th>
                    <th>Tên nhân viên</th>
                    <th>Tổng công</th>
                    <th>Lương</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->staff->id }}</td>
                        <td>{{ $item->staff->firstname . ' '. $item->staff->lastname }}</td>
                        <td>
                            @php
                                $total_working_of_day = 0;
                                if(isset($item->details)) {
                                    foreach($item->details as $detail){
                                        $total_working_of_day += $detail->total_working_of_day;
                                    }
                                }
                            @endphp
                            {{ number_format($total_working_of_day) }}
                        </td>
                        <td>{{ number_format($item->salary) }}</td>
                        <td>
                            <button class="btn btn-info btn-sm">Chi tiết</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--            <table class="table datatable-basics">--}}
            {{--                <thead>--}}
            {{--                <tr>--}}
            {{--                    <th>Mã nhân viên</th>--}}
            {{--                    <th>Tên nhân viên</th>--}}
            {{--                    <th>Ngày chấm công</th>--}}
            {{--                    <th>Công chuẩn của tháng</th>--}}
            {{--                    <th>Lương</th>--}}
            {{--                    <th>Lương 1 ngày</th>--}}
            {{--                    <th>Công đã làm</th>--}}
            {{--                    <th>Hệ số</th>--}}
            {{--                    <th>Tổng tiền</th>--}}
            {{--                </tr>--}}
            {{--                </thead>--}}
            {{--                <tbody>--}}
            {{--                @foreach($data as $item)--}}
            {{--                    @if(isset($item->details))--}}
            {{--                        @foreach($item->details as $detail)--}}
            {{--                            <tr>--}}
            {{--                                <td>{{ $detail->contract->staff->code }}</td>--}}
            {{--                                <td>{{ $detail->contract->staff->firstname . ' ' . $detail->contract->staff->lastname }}</td>--}}
            {{--                                <td>{{ $detail->day_detail }}</td>--}}
            {{--                                <td>{{ $detail->standard_days }}</td>--}}
            {{--                                <td>{{ number_format($detail->contract->salary) }}</td>--}}
            {{--                                <td>{{ number_format($detail->salary_per_day) }}</td>--}}
            {{--                                <td>{{ $detail->total_working_of_day }}</td>--}}
            {{--                                <td>{{ $detail->multiply_day }}</td>--}}
            {{--                                <td>{{ number_format($detail->salary_of_day) }}</td>--}}
            {{--                                --}}{{--                            <td class="text-center">--}}
            {{--                                --}}{{--                                <div class="list-icons">--}}
            {{--                                --}}{{--                                    <div class="dropdown">--}}
            {{--                                --}}{{--                                        <a href="#" class="list-icons-item" data-toggle="dropdown">--}}
            {{--                                --}}{{--                                            <i class="icon-menu9"></i>--}}
            {{--                                --}}{{--                                        </a>--}}

            {{--                                --}}{{--                                        <div class="dropdown-menu dropdown-menu-right">--}}
            {{--                                --}}{{--                                            <a href="{{ route('getDetailSalary', ['id' => $item->id]) }}" class="dropdown-item">Chi tiết</a>--}}
            {{--                                --}}{{--                                        </div>--}}
            {{--                                --}}{{--                                    </div>--}}
            {{--                                --}}{{--                                </div>--}}
            {{--                                --}}{{--                            </td>--}}
            {{--                            </tr>--}}
            {{--                        @endforeach--}}
            {{--                    @endif--}}
            {{--                @endforeach--}}
            {{--                </tbody>--}}
            {{--            </table>--}}
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/picker_date_init.js') }}"></script>
    <script>
    </script>
@endsection
