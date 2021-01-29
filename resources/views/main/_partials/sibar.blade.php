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
                        <div class="media-title font-weight-semibold">Username</div>
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
                    <a href="../full/index.html" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu nav-item-expanded nav-item-open">
                    <a href="#" class="nav-link"><i class="icon-stack"></i> <span>Starter kit</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Starter kit">
                        <li class="nav-item"><a href="#" class="nav-link">Menu 1</a></li>
                        <li class="nav-item"><a href="#" class="nav-link active">Menu 2</a></li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link">Menu 3</a>
                            <ul class="nav nav-group-sub">
                                <li class="nav-item"><a href="#" class="nav-link">Menu 3.1</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Menu 3.2</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- /main -->

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
