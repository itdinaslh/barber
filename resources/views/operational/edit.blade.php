<form action="{{ url('/operational/editpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="did" value="{{ $disc->id }}">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Operational</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="Nama">Nama Operasional</label>
            <input type="text" id="NamaOp" class="form-control" value="{{ $disc->NamaOp }}" autocomplete="off"
                name="NamaOp" required autofocus />
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
</form>
