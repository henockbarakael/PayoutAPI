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
                <img src="{{ URL::to('/assets/images/'. Auth::user()->logo) }}" alt="" width="182px" height="32px">
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
                @if (Auth::user()->niveau == "0")
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('admin.dashboard')}}">
                            <i class="ri-dashboard-line"></i> <span data-key="t-dashboards">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">User Management</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarAdvanceUI" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAdvanceUI">
                            <i class="mdi mdi-layers-triple-outline"></i> <span data-key="t-advance-ui">Merchant</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarAdvanceUI">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('admin.merchant.list')}}" class="nav-link" data-key="t-sweet-alerts">Merchant List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.merchant.user.list')}}" class="nav-link" data-key="t-nestable-list">Merchant User</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Bulk Payment</span></li>
                    
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('admin.payout')}}">
                            <i class="bx bx-dollar-circle"></i>  <span data-key="t-widgets">Bulk Payment</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('admin.payout.history')}}">
                            <i class="bx bx-list-ul"></i> <span data-key="t-widgets">Payment History</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('merchant.dashboard')}}">
                            <i class="ri-dashboard-line"></i> <span data-key="t-dashboards">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Pages</span></li>
                    
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('merchant.payout')}}">
                            <i class="bx bx-dollar-circle"></i>  <span data-key="t-widgets">Bulk Payment</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('merchant.payout.history')}}">
                            <i class="bx bx-list-ul"></i> <span data-key="t-widgets">Payment History</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
