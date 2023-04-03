<form action="{{ url('/service/addpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" value="{{ Auth::user()->id }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Produk</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="ProductName">Nama Service</label>
            <input type="text" class="form-control uppercase" name="ServiceName" required autofocus/>
        </div>
        <div class="form-group">
            <label for="Harga">Harga</label>
            <input type="text" class="form-control" name="Harga" required />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
