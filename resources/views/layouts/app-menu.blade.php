<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/favicon.jpg') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/favicon.jpg') }}" alt="" height="47">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/favicon.jpg') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/freshpay.png') }}" alt="" height="47">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('admin.dashboard')}}">
                        <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <!-- end Dashboard Menu -->

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Pages</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('admin.payout')}}">
                        <i class="mdi mdi-view-grid-plus-outline"></i> <span data-key="t-widgets">Payment Gateway</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('admin.payout.history')}}">
                        <i class="mdi mdi-chart-donut"></i> <span data-key="t-widgets">Payment Report</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
