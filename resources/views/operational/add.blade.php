<form action="{{ url('/operational/addpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}" />
    <input type="hidden" name="rPrice" id="rPrice" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Operational</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="Nama">Nama Operasional</label>
            <input type="text" id="NamaOp" class="form-control" name="NamaOp" autofocus autocomplete="off"
                required />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
