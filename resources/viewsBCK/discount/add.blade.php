<form action="{{ url('/discounts/addpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}" />
    <input type="hidden" name="rPrice" id="rPrice" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Discounts Card</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="Nama">DiscountID</label>
            <input type="text" id="DiscountID" class="form-control" name="DiscountID" autocomplete="off" maxLength="9" required autofocus />
        </div>
        <div class="form-group">
            <label for="Phone">Harga Discount</label>
            <input id="Price" type="text" class="form-control" name="Price" autocomplete="off" required/>
        </div>
        <div class="form-group">
            <label for="Occupation">Tanggal Kadaluarsa</label>
            <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input id="datemask" type="text" class="form-control" autocomplete="off" data-inputmask="'alias': 'dd/mm/yyyy'" name="ValidUntil" required data-mask>
            </div>
        </div>
        <div class="form-group">
            <label for="IdNum">Valid</label>
            <select class="form-control" name="IsValid">
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
