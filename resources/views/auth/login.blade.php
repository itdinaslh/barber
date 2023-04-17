<!DOCTYPE html>
<html>

<head>
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('/admin/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}" />
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<body>
    {{-- <body style="background-image: url('/img/bg-mb.png');
background-repeat: no-repeat;
background-size: cover;">
    <div class="container"> --}}
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
                <img class="profile-img" src="{{ asset('/admin/dist/img/photo.png') }}" alt="">
                <form class="form-signin" role="form" method="post" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <input type="text" class="form-control" name="username" placeholder="User Name" required
                        autofocus>
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif

                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <button class="btn btn-lg btn-primary btn-block" type="submit">
                        Sign in</button>
                    <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                </form>
            </div>
        </div>
    </div>
    </div>

</body>

</html>
