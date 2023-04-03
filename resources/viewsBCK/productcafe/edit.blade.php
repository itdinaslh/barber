<form action="{{ url('/productcafe/editpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="pid" value="{{ $prod->id }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Produk Cafe</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="ProductName">Nama Produk</label>
            <input type="text" class="form-control" name="Nama" autocomplete="off" value="{{ $prod->Nama }}" required autofocus />
        </div>
        <div class="form-group">
            <label for="Harga">Harga</label>
            <input type="number" class="form-control" name="Harga" value="{{ $prod->Harga }}" required />
        </div>
        <div class="form-group">
            <label for="Stock">Stock</label>
            <input type="number" class="form-control" name="Stock" value="{{ $prod->Stock }}" required />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
