@extends('main._layouts.master')

@section('css')
    <link href="{{ asset('assets/css/components_datatables.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('js')
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable_init.js') }}"></script>
@endsection

@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Danh sách hợp đồng</h5>
        </div>
        <div class="card-body">
            @if(session('message'))
                <div class="alert alert-{{ session('message')['type'] }} border-0 alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    {{ session('message')['message'] }}
                </div>
            @endif
        </div>
        <table class="table datatable-basic">
            <thead>
            <tr>
                <th>Nhân viên</th>
                <th>Ngày bắt đầu HĐ</th>
                <th>Ngày kết thúc HĐ</th>
                <th>Lương</th>
                <th>Ngày tạo</th>
                <th class="text-center">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->staff->firstname . ' ' . $item->staff->lastname}}</td>
                    <td>{{ $item->startDate }}</td>
                    <td>{{ $item->endDate }}</td>
                    <td>{{ number_format($item->salary) }}</td>
                    <td>{{ $item->createAt }}</td>
                    <td class="text-center">
                        <div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    @if(!$item->del)
                                        <a href="{{ route('getEditContract', ['id' => $item->id]) }}" class="dropdown-item">Chỉnh sửa</a>
                                        <a href="{{ route('getDeleteContract',['id' => $item->id]) }}" class="dropdown-item">Xóa</a>
                                    @else
                                        <a href="{{ route('getUndoContract', ['id' => $item->id]) }}" class="dropdown-item">Hoàn tác</a>
                                    @endif
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
@endsection
