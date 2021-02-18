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
                        <a href="#"><img src="{{ asset('global_assets/images/image.png') }}" width="38" height="38" class="rounded-circle" alt=""></a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold"><?php echo auth()->user()->firstname . ' ' . auth()->user()->lastname ?></div>
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
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    @if(auth()->user()->department == 2)
                        <a href="{{ action('DashboardController@index') }}" class="nav-link">
                            <i class="icon-stats-growth"></i>
                            <span>Dashboard</span>
                        </a>
                    @endif
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-stack"></i> <span>Công Phép</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Starter kit" style="display: none">
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
                                <i class="icon-clipboard6"></i>
                                <span>Bổ Sung Công Phép</span>
                            </a>
                        </li>
                        @if(auth()->user()->is_manager == 1 or auth()->user()->department == 2)
                            <li class="nav-item">
                                <a href="{{ action('TimeleaveController@approveTimeLeave') }}" class="nav-link">
                                    <i class="icon-clipboard6"></i>
                                    <span>Duyệt Công Phép</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <!-- /main -->

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
