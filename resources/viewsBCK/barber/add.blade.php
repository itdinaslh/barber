<form action="{{ url('/barberman/addpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Data Barberman</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="ProductName">Nama Barberman</label>
            <input type="text" class="form-control" name="Nama" required  autofocus />
        </div>
        <div class="form-group">
            <label for="IdNum">No. Identitas</label>
            <input type="text" class="form-control" name="IdNum" />
        </div>
        <div class="form-group">
            <label for="Phone">Telp</label>
            <input type="text" class="form-control" name="Phone" />
        </div>
        <div class="form-group">
            <label for="Level">Level</label>
            <select class="form-control" name="Level">
                <option value="S">Senior</option>
                <option value="M">Madya</option>
                <option value="J">Junior</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
