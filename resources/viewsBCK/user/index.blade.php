@extends('shared.master')
@section('title', 'User List')
@section('classcontent', 'content')
@section('PageHeader', 'User List')
@push('styles')
  <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/datatables.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.css') }}" />
@endpush

@section('content')
<!--Modal Window-->
<div id='myModal' class='modal fade in'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div id='myModalContent'></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table id="user" class="table table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $v)
                            <tr>
                                <td>{{ $v->id }}</td>
                                <td>{{ $v->username }}</td>
                                <td>{{ $v->name }}</td>
                                <td>{{ $v->PosName }}</td>
                                <td>
                                    <button type="button" name="btnEdit" class="btn btn-xs btn-success showMe" style="width:100%;height:25px;" data-href="/user/edit-{{ $v->id }}">Edit</button>
                                    <button type="button" name="btnPassword" class="btn btn-xs btn-warning showMe" style="width:100%;height:25px;margin-top:3px;" data-href="/user/changepassword-{{ $v->id}}">Change Password</button>
                                  </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="text-right">
            <button type="button" name="btnAdd" class="btn btn-primary showMe" data-href="{{ url('/user/add') }}">Add New</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('/admin/plugins/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/jquery-validate/jquery.validate.js') }}"></script>
  <script src="{{ asset('/js/modalForm.js') }}"></script>
  <script>
    $(document).on('shown.bs.modal', '.modal', function() {
        $(this).find('[autofocus]').focus();
    });
    $('#user').dataTable({
        responsive: true,
        lengthMenu:[5,10,15,20],
        autoWidth:false
    });

    $('#ChangeForm').validate({
        rules: {
            password:"required",
            password_confirm: {
                equalTo: '#password'
            }
        }
    });
  </script>

@endpush
