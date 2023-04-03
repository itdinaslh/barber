<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NM Barbershop | @yield('title')</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('/admin/bootstrap/css/bootstrap.min.css') }}" />
  <!-- <link rel="stylesheet" href="{{ asset('/admin/dist/css/AdminLTE.min.css') }}" /> -->
  @stack('styles')
</head>

<body>
  <div class="wrapper">
      <section class="@yield('classcontent')">
          @yield('content')
      </section>
    </div>
    <!-- /.content-wrapper -->
  </div>
<!-- ./wrapper -->
@stack('scripts')

</body>
</html>
