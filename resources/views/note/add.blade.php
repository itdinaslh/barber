<form action="{{ url('/notes/addpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Note</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="Nama">Title</label>
            <input type="text" id="Title" class="form-control" name="Title" autocomplete="off" required autofocus />
        </div>
        <div class="form-group">
            <label for="Phone">Struk Note</label>
            <textarea name="Content" rows="5" cols="8" class="form-control textarea" required></textarea>
        </div>
        <div class="form-group">
            <label for="IdNum">Activate</label>
            <select class="form-control" name="Active">
                <option value="0">No</option>
                <option value="1" selected>Yes</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
