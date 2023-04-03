<form action="{{ url('/productcafe/addpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Produk Cafe</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="ProductID">Kode Produk</label>
            <input id="ProductID" type="number" class="form-control" name="ProductID"
            oninput="this.value=this.value.slice(0,this.maxLength)" maxlength="6" autocomplete="off" required autofocus />
        </div>
        <div class="form-group">
            <label for="ProductName">Nama Produk</label>
            <input type="text" class="form-control uppercase" name="Nama" autocomplete="off" required />
        </div>
        <div class="form-group">
            <label for="">Type Produk</label>
            <select class="form-control" name="ProductType" id="ProductType">
                <option value="0">Cafe</option>
                <option value="1">Pulsa</option>
            </select>
        </div>
        <div class="form-group">
            <label for="Harga">Harga</label>
            <input type="number" class="form-control" name="Harga" required />
        </div>
        <div class="form-group">
            <label for="Stock">Stock</label>
            <input type="number" class="form-control" name="Stock" required />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
