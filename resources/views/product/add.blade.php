<form action="{{ url('/product/addpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Produk</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="ProductName">Nama Produk</label>
            <input type="text" class="form-control uppercase" name="ProductName" autocomplete="off" required autofocus />
        </div>
        <div class="form-group">
            <label for="Harga">Harga</label>
            <input type="text" class="form-control" name="Harga" autocomplete="off" required />
        </div>
        <div class="form-group">
            <label for="Komisi">Komisi</label>
            <input type="text" class="form-control" name="Komisi" autocomplete="off" required />
        </div>
        <div class="form-group">
            <label for="Stock">Stock</label>
            <input type="text" class="form-control" name="Stock" autocomplete="off" required />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
