<form action="{{ url('/discounts/addpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}" />
    <input type="hidden" name="rPrice" id="rPrice" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Discounts Card</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="Phone">Harga Discount</label>
            <input id="Price" type="text" class="form-control" name="Price" autocomplete="off" required
                autofocus />
        </div>
        <div class="form-group">
            <label for="Phone">Tanggal Mulai Diskon</label>
            <input id="Price" type="text" class="form-control tgl" name="Price" autocomplete="off" required
                autofocus />
        </div>
        <div class="form-group">
            <label for="Phone">Tanggal Akhir Diskon</label>
            <input id="Price" type="text" class="form-control tgl" name="Price" autocomplete="off" required
                autofocus />
        </div>
        <div class="form-group">
            <label for="IdNum">Valid</label>
            <select class="form-control" name="IsValid">
                <option value="0">No</option>
                <option value="1" selected>Yes</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Note</label>
            <input type="text" name="Note" class="form-control" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
