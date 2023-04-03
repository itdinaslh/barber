<form id="ChangeForm" action="/user/editpost" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ $user->id }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Data User"</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="password">Username</label>
            <input type="text" class="form-control" name="username" value="{{ $user->username }}" disabled />
        </div>
        <div class="form-group">
            <label for="password">Nama</label>
            <input type="text" id="name" class="form-control" name="name" value="{{ $user->name }}" required autofocus/>
        </div>
        <div class="form-group">
            <label for="password">Posisi</label>
            <select class="form-control" name="posid">
                @foreach($pos as $v)
                    <option value="{{ $v->id }}" @if ($user->posid == $v->id) selected @endif>{{ $v->PosName }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Save</button>
    </div>
</form>
