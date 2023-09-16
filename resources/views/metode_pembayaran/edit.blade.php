<form action="{{ url('/metode_pembayaran/editpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="PembayaranID" value="{{ $data->id }}">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Metode Pembayaran</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="Nama">Metode Pembayaran</label>
            <input type="text" id="Title" class="form-control" name="Name" autocomplete="off" value="{{ $data->Name }}" required autofocus />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
