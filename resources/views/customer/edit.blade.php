<form action="{{ url('/customer/editpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}" />
    <input type="hidden" name="sid" value="{{ $cust->id }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Data Customer</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="Nama">Member ID</label>
            <input type="text" class="form-control uppercase" name="CustomerID" value="{{ $cust->id }}" disabled />
        </div>
        <div class="form-group">
            <label for="Nama">Nama Customer</label>
            <input type="text" class="form-control uppercase" name="Nama" value="{{ $cust->Nama }}" required autofocus/>
        </div>
        <div class="form-group">
            <label for="IdNum">No Identitas</label>
            <input type="number" class="form-control" maxlength="16" name="IdNum" value="{{ $cust->IdNum }}"  />
        </div>
        <div class="form-group">
            <label for="Phone">Telp</label>
            <input type="text" class="form-control" name="Phone" value="{{ $cust->Phone }}" />
        </div>
        <div class="form-group">
            <label for="Occupation">Tanggal Lahir</label>
            <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input id="datemask" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" name="BirthDate" value="{{ $birthdate }}" data-mask>
            </div>
        </div>
        <div class="form-group">
            <label for="Occupation">Pekerjaan</label>
            <input type="text" class="form-control uppercase" name="Occupation" value="{{ $cust->Occupation }}" />
        </div>
        <div class="form-group">
            <label for="City">Kota</label>
            <input type="text" class="form-control uppercase" name="City" value="{{ $cust->City }}" />
        </div>
        <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" class="form-control" name="Email" value="{{ $cust->Email }}" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
