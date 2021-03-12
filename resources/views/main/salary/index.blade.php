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
            <h5 class="card-title">Danh sách kì lương</h5>
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
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th class="text-center">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->fromDate }}</td>
                    <td>{{ $item->toDate }}</td>
                    <td class="text-center">
                        <div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ route('getDetailSalary', ['id' => $item->id]) }}" class="dropdown-item">Chi tiết</a>
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
