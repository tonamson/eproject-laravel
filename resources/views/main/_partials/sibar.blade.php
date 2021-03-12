<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="{{ action('StaffController@viewProfile') }}"><img src="{{ asset('images/user/avatar/default_avatar.png') }}" width="38" height="38" class="rounded-circle" alt=""></a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold"><?php echo auth()->user()->firstname . ' ' . auth()->user()->lastname ?></div>
                        <div class="media-title font-weight-semibold">{{ session('department_name') }} - <?php echo auth()->user()->is_manager == 1 ? 'Quản lý' : 'Nhân viên' ?></div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item">
                    <a href="{{ action('ViewmenuController@index') }}" class="nav-link">
                        <i class="icon-home2"></i>
                        <span>Trang Chủ</span>
                    </a>
                </li>

                @if(auth()->user()->department == 2)
                    <li class="nav-item">
                        <a href="{{ action('DashboardController@index') }}" class="nav-link">
                            <i class="icon-stats-growth"></i>
                            <span>Biểu Đồ</span>
                        </a>
                    </li>

                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-credit-card"></i> <span>Phòng Ban</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Starter kit" style="display: none">
                            <li class="nav-item">
                                <a href="{{ action('DepartmentController@index') }}" class="nav-link">
                                    <i class="icon-list"></i>
                                    <span>Danh sách Phòng Ban</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ action('DepartmentController@listUndo') }}" class="nav-link">
                                    <i class="icon-trash"></i>
                                    <span>Thùng rác</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-user"></i> <span>Nhân viên</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Starter kit" style="display: none">
                            <li class="nav-item">
                                <a href="{{ action('StaffController@index') }}" class="nav-link">
                                    <i class="icon-list"></i>
                                    <span>Danh sách</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ action('StaffController@vaddStaff') }}" class="nav-link">
                                    <i class="icon-plus2"></i>
                                    <span>Thêm nhân viên</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ action('StaffController@listUndo') }}" class="nav-link">
                                    <i class="icon-trash"></i>
                                    <span>Thùng rác</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-graduation"></i> <span>Bằng Cấp</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Starter kit" style="display: none">
                            <li class="nav-item">
                                <a href="{{ action('EducationController@index') }}" class="nav-link">
                                    <i class="icon-list"></i>
                                    <span>Danh sách</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ action('EducationController@addEducation') }}" class="nav-link">
                                    <i class="icon-plus2"></i>
                                    <span>Thêm Văn Bằng</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(auth()->user()->department == 2 or auth()->user()->is_manager == 1)
                    <li class="nav-item">
                        <a href="{{ action('TransferController@list') }}" class="nav-link">
                            <i class="icon-transmission"></i>
                            <span>Điều Chuyển</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->department == 2)
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-newspaper2"></i> <span>Hợp đồng</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Starter kit" style="display: none">
                            <li class="nav-item">
                                <a href="{{ route('getListContract', ['del' => false]) }}" class="nav-link">
                                    <i class="icon-list"></i>
                                    <span>Danh sách</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('getCreateContract') }}" class="nav-link">
                                    <i class="icon-plus2"></i>
                                    <span>Tạo hợp đồng</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('getListContract', ['del' => true]) }}" class="nav-link">
                                    <i class="icon-trash"></i>
                                    <span>Thùng rác</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-stack"></i> <span>Công Phép</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Starter kit" style="display: none">
                        @if(auth()->user()->department == 2 or auth()->user()->id == 7)
                            <a href="{{ action('SpecialDateController@index') }}" class="nav-link">
                                <i class="icon-calendar2"></i>
                                <span>Quản Lý Ngày Lễ</span>
                            </a>
                        @endif
                        @if(auth()->user()->is_manager == 1)
                            <a href="{{ action('SpecialDateController@requestOverTime') }}" class="nav-link">
                                <i class="icon-calendar2"></i>
                                @if(auth()->user()->id == 7)
                                    <span>Danh Sách Đề Xuất Tăng Ca</span>
                                @else
                                    <span>Đề Xuất Tăng Ca</span>
                                @endif
                            </a>
                        @endif
                        @if(auth()->user()->id != 7)
                            <li class="nav-item">
                                <a href="{{ action('CheckInOutController@index') }}" class="nav-link">
                                    <i class="icon-clipboard5"></i>
                                    <span>Chấm Công GPS</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ action('CheckInOutController@show') }}" class="nav-link">
                                    <i class="icon-clipboard6"></i>
                                    <span>Lịch Sử Chấm Công</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ action('TimeleaveController@index') }}" class="nav-link">
                                    <i class="icon-calendar"></i>
                                    <span>Bổ Sung Công Phép</span>
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->is_manager == 1 or auth()->user()->department == 2)
                            <li class="nav-item">
                                <a href="{{ action('TimeleaveController@approveTimeLeave') }}" class="nav-link">
                                    <i class="icon-checkbox-checked"></i>
                                    <span>Duyệt Công Phép</span>
                                    {{-- @if(auth()->user()->department == 2 && auth()->user()->is_manager == 1)
                                        <span>Duyệt Công Phép</span>
                                    @elseif(auth()->user()->department == 2)
                                        <span>Xem Công Phép</span>
                                    @else
                                        <span>Duyệt Bổ Sung Công</span>
                                    @endif --}}
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->department == 2)
                            <li class="nav-item">
                                <a href="{{ action('TimeleaveController@getAllStaffTime') }}" class="nav-link">
                                    <i class="icon-paragraph-left2"></i>
                                    <span>Lưới Công</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                @if(auth()->user()->department == 2)
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-cash3"></i> <span>Lương</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Starter kit" style="display: none">
                            <li class="nav-item">
                                <a href="{{ route('getIndexSalary') }}" class="nav-link">
                                    <i class="icon-list"></i>
                                    <span>Danh sách</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('getCreateSalary') }}" class="nav-link">
                                    <i class="icon-plus2"></i>
                                    <span>Tính lương</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('getListContract', ['del' => true]) }}" class="nav-link">
                                    <i class="icon-trash"></i>
                                    <span>Thùng rác</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-racing"></i> <span>KPI</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Starter kit" style="display: none">
                        @if(auth()->user()->id != 7)
                            <li class="nav-item">
                                <a href="{{ action('KpiController@setKpi') }}" class="nav-link">
                                    <i class="icon-finish"></i>
                                    <span>Thiết Lập KPI</span>
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->is_manager == 1 or auth()->user()->department == 2)
                            <li class="nav-item">
                                <a href="{{ action('KpiController@listKpi') }}" class="nav-link">
                                    <i class="icon-list2"></i>
                                    <span>Danh Sách KPI</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ action('AboutcompanyController@index') }}" class="nav-link">
                        <i class="icon-info22"></i>
                        <span>Giới Thiệu</span>
                    </a>
                </li>
                <!-- /main -->

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
