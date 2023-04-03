<form role="form" method="POST" action="{{ url('/user/addpost') }}">
    {{ csrf_field() }}
    <input type="hidden" name="level" id="level" value="M" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Data User</h4>
    </div>

    <div class="modal-body">
        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <label for="name">Username</label>
            <input id="name" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus />

            @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Name</label>
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required />
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('posid') ? ' has-error' : '' }}">
            <label for="posid">Position</label>

            <select id="posid" class="select2 form-control" name="posid" required>
                <option value="1" data-level="M">Manager</option>
                <option value="3" data-level="C">Cashier</option>
            </select>

            @if ($errors->has('posid'))
                <span class="help-block">
                    <strong>{{ $errors->first('posid') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password">Password</label>

            <input id="password" type="password" class="form-control" name="password" required />

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

        </div>

        <div class="form-group">
            <label for="password-confirm">Confirm Password</label>

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

        </div>

        <div class="form-group">
            <div class="text-right">
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </div>
</form>
