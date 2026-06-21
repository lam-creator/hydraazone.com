<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="text-center brand-link">
        <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

				@if (Auth::guard('admin')->user()->can('menu.admin-management'))
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.admins') || request()->routeIs('admin.permissions.index') || request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Admin Management<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::guard('admin')->user()->can('menu.admin'))
                        <li class="nav-item">
                            <a href="{{ route('admin.admin') }}"
                                class="nav-link {{ request()->routeIs('admin.admin') ? 'active' : '' }}"><i
                                    class="far fa-user nav-icon"></i>
                                <p>Admin</p>
                            </a>
                        </li>
						@endif

						@if (Auth::guard('admin')->user()->can('menu.admin'))
                        <li class="nav-item">
                            <a href="{{ route('admin.admins.index') }}"
                                class="nav-link {{ request()->routeIs('admin.admins.index') ? 'active' : '' }}"><i
                                    class="far fa-user nav-icon"></i>
                                <p>Admin</p>
                            </a>
                        </li>
						@endif

                        @if (Auth::guard('admin')->user()->can('menu.permission'))
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.index') }}" class="nav-link"><i
                                    class="far fa-user nav-icon"></i>
                                <p>Permission</p>
                            </a>
                        </li>
                        @endif

                        @if (Auth::guard('admin')->user()->can('menu.role'))
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}" class="nav-link"><i
                                    class="far fa-user nav-icon"></i>
                                <p>Role</p>
                            </a>
                        </li>
                        @endif

                    </ul>
                </li>
				@endif


                {{-- City menu  --}}
				@if (Auth::guard('admin')->user()->can('menu.city-management'))
                <li class="nav-item">
                    <a href="{{ route('admin.city') }}"
                        class="nav-link {{ request()->routeIs('admin.city') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-city"></i>
                        <p>City</p>
                    </a>
                </li>
				@endif

                {{-- Settings menu  --}}
				@if (Auth::guard('admin')->user()->can('menu.website-settings-management'))
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.website_settings') || request()->routeIs('admin.website_settings') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Website Settings<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
						@if (Auth::guard('admin')->user()->can('menu.website-slider'))
                        <li class="nav-item">
                            <a href="{{ route('admin.slider') }}"
                                class="nav-link {{ request()->routeIs('admin.slider') ? 'active' : '' }}"><i
                                    class="nav-icon fas fa-th"></i>
                                <p>Website Slider</p>
                            </a>
                        </li>
						@endif

						@if (Auth::guard('admin')->user()->can('menu.basic-settings'))
                        <li class="nav-item">
                            <a href="{{ route('admin.website_settings') }}"
                                class="nav-link {{ request()->routeIs('admin.website_settings') ? 'active' : '' }}"><i
                                    class="nav-icon fas fa-th"></i>
                                <p>Basic Settings</p>
                            </a>
                        </li>
						@endif

                    </ul>
                </li>
				@endif

                {{-- Products menu  --}}
				@if (Auth::guard('admin')->user()->can('menu.Products'))
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.category') || request()->routeIs('admin.category') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-dolly-flatbed"></i>
                        <p>Products<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">

						@if (Auth::guard('admin')->user()->can('menu.category'))
                        <li class="nav-item">
                            <a href="{{ route('admin.category') }}"
                                class="nav-link {{ request()->routeIs('admin.category') ? 'active' : '' }}"><i
                                    class="nav-icon fas fa-th"></i>
                                <p>Category</p>
                            </a>
                        </li>
						@endif

						@if (Auth::guard('admin')->user()->can('menu.unit'))
                        <li class="nav-item">
                            <a href="{{ route('admin.unit') }}"
                                class="nav-link {{ request()->routeIs('admin.unit') ? 'active' : '' }}"><i
                                    class="nav-icon fas fa-th"></i>
                                <p>Unit</p>
                            </a>
                        </li>
						@endif

						@if (Auth::guard('admin')->user()->can('menu.all-product'))
                        <li class="nav-item">
                            <a href="{{ route('admin.product') }}"
                                class="nav-link {{ request()->routeIs('admin.product') ? 'active' : '' }}"><i
                                    class="nav-icon fas fa-th"></i>
                                <p>All Product</p>
                            </a>
                        </li>
						@endif

                    </ul>
                </li>
				@endif


                {{-- Order menu  --}}
				@if (Auth::guard('admin')->user()->can('menu.order'))
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.processing.orders.index') || request()->routeIs('admin.approved.orders.index') || request()->routeIs('admin.cancelled.orders.index') || request()->routeIs('admin.delivered.orders.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Order<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">

						@if (Auth::guard('admin')->user()->can('menu.order-processing'))
                        <li class="nav-item">
                            <a href="{{ route('admin.processing.orders.index') }}"
                                class="nav-link {{ request()->routeIs('admin.processing.orders.index') ? 'active' : '' }}"><i
                                    class="nav-icon fas fa-th"></i>
                                <p>Order processing</p>
                            </a>
                        </li>
						@endif

						@if (Auth::guard('admin')->user()->can('menu.order-approved'))
                        <li class="nav-item">
                            <a href="{{ route('admin.approved.orders.index') }}"
                                class="nav-link {{ request()->routeIs('admin.approved.orders.index') ? 'active' : '' }}"><i
                                    class="nav-icon fas fa-th"></i>
                                <p>Order approved</p>
                            </a>
                        </li>
						@endif

						@if (Auth::guard('admin')->user()->can('menu.order-delivered'))
                        <li class="nav-item">
                            <a href="{{ route('admin.delivered.orders.index') }}"
                                class="nav-link {{ request()->routeIs('admin.delivered.orders.index') ? 'active' : '' }}"><i
                                    class="nav-icon fas fa-th"></i>
                                <p>Order delivered</p>
                            </a>
                        </li>
						@endif

						@if (Auth::guard('admin')->user()->can('menu.order-cancelled'))
                        <li class="nav-item">
                            <a href="{{ route('admin.cancelled.orders.index') }}"
                                class="nav-link {{ request()->routeIs('admin.cancelled.orders.index') ? 'active' : '' }}"><i
                                    class="nav-icon fas fa-th"></i>
                                <p>Order cancelled</p>
                            </a>
                        </li>
						@endif

                    </ul>
                </li>
				@endif


                {{-- Coupon menu  --}}
				@if (Auth::guard('admin')->user()->can('menu.coupon-management'))
                <li class="nav-item">
                    <a href="{{ route('admin.coupon') }}"
                        class="nav-link {{ request()->routeIs('admin.coupon') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-gift"></i>
                        <p>Coupon</p>
                    </a>
                </li>
				@endif


				@if (Auth::guard('admin')->user()->can('menu.contact-messages'))
                <li class="nav-item">
                    <a href="{{ route("admin.contact") }}" class="nav-link {{ request()->routeIs('admin.contact') ? 'active' : '' }}"><i class="nav-icon fas fa-barcode"></i>
                        <p>Contact Messages</p>
                    </a>
                </li>
				@endif


                {{-- Banner menu  --}}
                <li class="nav-item">
                    <a href="{{ route('admin.banner') }}"
                        class="nav-link {{ request()->routeIs('admin.banner') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-th"></i>
                        <p>Banner</p>
                    </a>
                </li>


                {{-- Feature menu  --}}
                <li class="nav-item">
                    <a href="{{ route('admin.feature') }}"
                        class="nav-link {{ request()->routeIs('admin.feature') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-th"></i>
                        <p>Feature</p>
                    </a>
                </li>

                {{-- Trust menu  --}}
                <li class="nav-item">
                    <a href="{{ route('admin.trust') }}"
                        class="nav-link {{ request()->routeIs('admin.trust') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-th"></i>
                        <p>Trust</p>
                    </a>
                </li>





                {{-- Page menu  --}}
                <li class="nav-item">
                    <a href="{{ route('admin.page') }}"
                        class="nav-link {{ request()->routeIs('admin.page') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-th"></i>
                        <p>Page</p>
                    </a>
                </li>


                {{-- Sitemap menu --}}

                <li class="nav-item">
                    <a href="{{ url('/sitemap.xml') }}"
                        class="nav-link"><i class="nav-icon fas fa-th"></i>
                        <p>Sitemap Link</p><span class="float-right badge bg-danger">New</span>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
