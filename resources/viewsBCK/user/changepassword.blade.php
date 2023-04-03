<form id="ChangeForm">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ $user->id }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Change Password "{{ $user->name }}"</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" id="password" class="form-control" name="password" required autofocus/>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">CLose</button>
        <button type="submit" class="btn btn-success">Change Password</button>
    </div>
</form>
