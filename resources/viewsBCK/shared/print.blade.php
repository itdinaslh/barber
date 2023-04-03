<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NM Barbershop | @yield('title')</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('/admin/bootstrap/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/font-awesome/css/font-awesome.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/ionicons/css/ionicons.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/dist/css/AdminLTE.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/dist/css/skins/skin-red.css') }}" />
  @stack('styles')
</head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">
      <!-- Logo -->
      <a href="#" class="logo">
        <span class="logo-mini"><b>NM</b>B</span>
        <span class="logo-lg"><b>NM</b>Barbershop</span>
      </a>

      <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="{{ asset('/admin/dist/img/user.jpg') }}" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="{{ asset('/admin/dist/img/user.jpg') }}" class="img-circle" alt="User Image">

                  <p>
                    {{ Auth::user()->name }}
                    <small>Joined since Nov. 2016</small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    @include('shared.sidebar')

    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          @yield('PageHeader')
          <small>@yield('Description')</small>
        </h1>
      </section>

      <section class="@yield('classcontent')">
          @yield('content')
      </section>
      <div class="clearfix"></div>
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        v1.0.0
      </div>
      <strong>Copyright &copy; 2017 <a href="#">NM Barbershop</a>.</strong>
    </footer>
  </div>
<!-- ./wrapper -->

<script src="{{ asset('/admin/plugins/jQuery/jquery-3.2.0.min.js') }}"></script>
<script src="{{ asset('/admin/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/admin/dist/js/app.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/fastclick/fastclick.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
@stack('scripts')

</body>
</html>
