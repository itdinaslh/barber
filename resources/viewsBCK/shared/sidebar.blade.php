<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('/admin/dist/img/user.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Main Menu</li>
            <li class="{{ Request::path() == '/' ? 'active' : '' }}">
                <a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ Request::path() == 'transaction/cashier' ? 'active' : '' }}">
                <a href="{{ url('/transaction/cashier') }}"><i class="fa fa-th-list"></i> <span>Transaksi</span></a>
            </li>
            {{-- <li class="{{Request::path() == 'transaction/cafe' ? 'active' : ''}}">
          <a href="{{ url('/transaction/cafe') }}"><i class="fa fa-coffee"></i> <span>Transaksi Cafe</span></a>
      </li> --}}
            <li class="{{ Request::path() == 'transaction/invoice/reprint' ? 'active' : '' }}">
                <a href="{{ url('/transaction/invoice/reprint') }}"><i class="fa fa-print"></i> <span>Reprint
                        Struk</span></a>
            </li>
            <li class="{{ Request::path() == 'customers/all' ? 'active' : '' }}">
                <a href="{{ url('/customer/all') }}"><i class="fa fa-user-o"></i> <span>Customers</span></a>
            </li>
            @if (Auth::user()->posid == 1)
                <li class="treeview {{ Request::is('stocklist/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-gear"></i> <span>Kontrol Stock</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::path() == 'stocklist/barbershop' ? 'active' : '' }}">
                            <a href="{{ url('/stocklist/barbershop') }}">Product Barbershop</a>
                        </li>
                        {{-- <li class="{{ Request::path() == 'stocklist/cafe' ? 'active' : '' }}">
                            <a href="{{ url('/stocklist/cafe') }}">Product Cafe</a>
                        </li> --}}
                    </ul>
                </li>
                <li class="treeview {{ Request::is('barberman/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-cut"></i> <span>Barberman</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::path() == 'barberman/all' ? 'active' : '' }}">
                            <a href="{{ url('/barberman/all') }}">Data</a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('master/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-database"></i> <span>Master Data</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::path() == 'master/products' ? 'active' : '' }}">
                            <a href="{{ url('/master/products') }}">Product</a>
                        </li>
                        {{-- <li class="{{Request::path() == 'master/productcafe' ? 'active' : ''}}">
                  <a href="{{ url('/master/productcafe') }}">Product Cafe</a>
              </li> --}}
                        <li class="{{ Request::path() == 'master/services' ? 'active' : '' }}">
                            <a href="{{ url('/master/services') }}">Service</a>
                        </li>
                        <li class="{{ Request::path() == 'master/discounts' ? 'active' : '' }}">
                            <a href="{{ url('/master/discounts') }}">Discounts</a>
                        </li>
                        <li class="{{ Request::path() == 'master/vouchers' ? 'active' : '' }}">
                            <a href="{{ url('/master/vouchers') }}">Vouchers</a>
                        </li>
                        <li class="{{ Request::path() == 'master/notes' ? 'active' : '' }}">
                            <a href="{{ url('/master/notes') }}">Struk Notes</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::path() == '/report' ? 'active' : '' }}">
                    <a href="/report"><i class="fa fa-clone"></i> <span>Reports</span>
                    </a>
                </li>
                <li class="{{ Request::path() == 'user/all' ? 'active' : '' }}">
                    <a href="{{ url('/user/all') }}"><i class="fa fa-user-plus"></i> <span>Users</span></a>
                </li>
            @endif

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
