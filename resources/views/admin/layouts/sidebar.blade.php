<?php
    $segments = request()->segments();
    $count = count($segments);
    if($count == 3){
        $segments = isset($segments[2])?$segments[2]:'';;
    }else{
        $segments = isset($segments[1])?$segments[1]:'';
    }

    if($controllerName != 'InvoiceController' && !empty(request()->get('type'))){
        $segments = \App\Models\User::changeTypes[request()->get('type')];
    }
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:void(0)" class="brand-link">
        <img src="{{ asset('images/proposal-pdf/fire.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="width: 39px;opacity: .8;height: 33px;">
        <span class="brand-text font-weight-light">Ssscientific</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->fullname }} <br />({{ \App\Models\Admin\Role::ROLENAMES[Auth::user()->role_id] }})</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
{{--        <div class="form-inline">--}}
{{--            <div class="input-group" data-widget="sidebar-search">--}}
{{--                <input class="form-control form-control-sidebar" type="search" placeholder="Search"--}}
{{--                       aria-label="Search">--}}
{{--                <div class="input-group-append">--}}
{{--                    <button class="btn btn-sidebar">--}}
{{--                        <i class="fas fa-search fa-fw"></i>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ ($prefix == '' && $controllerName == 'DashboardController')?'active':'' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard</p>
                        </p>

                    </a>
                </li>
                <li class="nav-header"></li>
{{--                @if(Auth::user()->role_id == \App\Models\Admin\Role::ROLE_ADMIN )--}}
                <li class="nav-item  {{ $prefix == 'admin'?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ $prefix == 'admin'?'active':'' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Master Info
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('configs') }}" class="nav-link  {{ $controllerName == 'ConfigsController'?'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Configs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles') }}" class="nav-link  {{ $controllerName == 'RolesController'?'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}" class="nav-link  {{ ($controllerName == 'CustomerController'  && $segments == 'users')?'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.vendors') }}" class="nav-link  {{ ($controllerName == 'CustomerController' && $segments == 'vendors')?'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Vendors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customers') }}" class="nav-link  {{ ($controllerName == 'CustomerController' && $segments == 'customers')?'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categories') }}" class="nav-link  {{ $controllerName == 'CategoryController'?'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('products') }}" class="nav-link {{ ($controllerName == 'ProductController'  && $segments != 'accessories')?'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('accessories') }}" class="nav-link {{ ($controllerName == 'ProductController'  && $segments == 'accessories')?'active':'' }}">--}}
{{--                                <i class="far fa-circle nav-icon"></i>--}}
{{--                                <p>Accessories</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                    </ul>
                </li>
{{--                @endif--}}
                <li class="nav-item  {{ ($prefix == '' && $controllerName == 'QuoteController')?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ ($prefix == '' && $controllerName == 'QuoteController')?'active':'' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Quote Info
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('quotes') }}" class="nav-link  {{ $controllerName == 'QuoteController'?'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Quotations</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item  {{ ($prefix == '' && ($controllerName == 'InvoiceController' || $controllerName == 'PurchaseOrderController'))?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ ($prefix == '' && $controllerName == 'InvoiceController')?'active':'' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Order Info
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('purchase.orders') }}" class="nav-link  {{ $controllerName == 'PurchaseOrderController'?'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Vendor P.O.</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('invoices',['type' => \App\Models\Admin\Invoice::INVOICE]) }}" class="nav-link  {{ ($controllerName == 'InvoiceController' && request()->get('type') == \App\Models\Admin\Invoice::INVOICE) ?'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tax Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('invoices',['type' => \App\Models\Admin\Invoice::PROFORMA_INVOICE]) }}" class="nav-link  {{ ($controllerName == 'InvoiceController' && request()->get('type') == \App\Models\Admin\Invoice::PROFORMA_INVOICE) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Proforma Invoices</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="dropdown-item nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
