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
            <li class="{{ Request::path() == '/' ? 'active' : '' }}">
                <a href="{{ url('/') }}"> <span>Kembali ke web</span></a>
            </li>
            <li class="header">Main Menu</li>
            <li class="{{ Request::path() == '/dashboard' ? 'active' : '' }}">
                <a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ Request::path() == 'transaction/cashier' ? 'active' : '' }}">
                <a href="{{ url('/transaction/cashier') }}"><i class="fa fa-th-list"></i> <span>Transaksi
                        Barber</span></a>
            </li>
            {{-- <li class="{{ Request::path() == 'transaction/cafe' ? 'active' : '' }}">
                <a href="{{ url('/transaction/cafe') }}"><i class="fa fa-coffee"></i> <span>Transaksi Cafe</span></a>
            </li> --}}
            <li class="{{ Request::path() == 'transaction/invoice/reprint' ? 'active' : '' }}">
                <a href="{{ url('/transaction/invoice/reprint') }}"><i class="fa fa-print"></i> <span>Reprint
                        Struk</span></a>
            </li>
            <li class="treeview {{ Request::is('data/*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-address-card-o"></i> <span>Data Kasir</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::path() == 'data/vouchers' ? 'active' : '' }}">
                        <a href="{{ url('/data/vouchers') }}">Vouchers</a>
                    </li>
                    <li class="{{ Request::path() == 'data/discounts' ? 'active' : '' }}">
                        <a href="{{ url('/data/discounts') }}">Discounts</a>
                    </li>
                    {{-- <li class="{{ Request::path() == 'data/productcafe' ? 'active' : '' }}">
                        <a href="{{ url('/data/productcafe') }}">Product Cafe</a>
                    </li> --}}
                    <li class="{{ Request::path() == 'data/reports/lapbbman' ? 'active' : '' }}">
                        <a href="{{ url('/data/reports/lapbbman') }}"><i class="fa fa-user-plus"></i> <span>Lap. Bbman
                                Daily</span></a>
                    </li>
                    <li class="{{ Request::path() == 'data/customers/all' ? 'active' : '' }}">
                        <a href="{{ url('data/customer/all') }}"><i class="fa fa-user-o"></i>
                            <span>Customers</span></a>
                    </li>
                </ul>
            </li>
            @if (Auth::user()->posid == 1)
                <li class="{{ Request::path() == 'cost_op' ? 'active' : '' }}">
                    <a href="{{ url('/cost_op') }}"><i class="fa fa-th-list"></i> <span>Biaya
                            Pengeluaran</span></a>
                </li>
                <li class="treeview {{ Request::is('master/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-database"></i> <span>Master Data</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::path() == 'master/barberman/all' ? 'active' : '' }}">
                            <a href="{{ url('/master/barberman/all') }}"><i class="fa fa-cut"></i>
                                <span>Barberman</span></a>
                        </li>
                        <li class="{{ Request::path() == 'master/products' ? 'active' : '' }}">
                            <a href="{{ url('/master/products') }}">Product</a>
                        </li>
                        {{-- <li class="{{ Request::path() == 'master/productcafe' ? 'active' : '' }}">
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
                        <li class="{{ Request::path() == 'master/operational' ? 'active' : '' }}">
                            <a href="{{ url('/master/operational') }}">Operational</a>
                        </li>
                        <li class="{{ Request::path() == 'master/user/all' ? 'active' : '' }}">
                            <a href="{{ url('/master/user/all') }}"><i class="fa fa-user-plus"></i>
                                <span>Users</span></a>
                        </li>
                        <li class="{{ Request::path() == 'master/metode_pembayaran' ? 'active' : '' }}">
                            <a href="{{ url('/master/metode_pembayaran') }}"><i class="fa fa-user-plus"></i>
                                <span>Metode Pembayran</span></a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('reports/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-clone"></i> <span>Reports</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::path() == 'reports/master' ? 'active' : '' }}">
                            <a href="{{ url('/reports/master') }}">Transaksi</a>
                        </li>
                        {{-- <li class="{{ Request::path() == 'reports/cafe' ? 'active' : '' }}">
                            <a href="{{ url('/reports/cafe') }}">Transaksi Cafe</a>
                        </li> --}}
                        <li class="{{ Request::path() == 'cashier/reports/lapbbman' ? 'active' : '' }}">
                            <a href="{{ url('/reports/lapbbman') }}">Lap BBMan</a>
                        </li>
                        <li class="{{ Request::path() == 'cashier/reports/recap' ? 'active' : '' }}">
                            <a href="{{ url('/reports/recap') }}">Rekap Pendapatan</a>
                        </li>
                        <li class="{{ Request::path() == 'cashier/reports/bbdetails' ? 'active' : '' }}">
                            <a href="#">Detail Barberman</a>
                        </li>

                    </ul>
                </li>
            @endif

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
