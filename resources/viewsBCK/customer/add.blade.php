<form action="{{ url('/customer/addpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Data Customer</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="Nama">Nama</label>
            <input type="text" id="nama" class="form-control" name="Nama" required autofocus />
        </div>
        <div class="form-group">
            <label for="Phone">Telp</label>
            <input type="text" class="form-control" name="Phone" />
        </div>
        <div class="form-group">
            <label for="Occupation">Tanggal Lahir</label>
            <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input id="datemask" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" name="BirthDate" data-mask>
            </div>
        </div>
        <div class="form-group">
            <label for="IdNum">No Identitas</label>
            <input type="text" class="form-control" name="IdNum" />
        </div>
        <div class="form-group">
            <label for="Occupation">Pekerjaan</label>
            <input type="text" class="form-control" name="Occupation" />
        </div>
        <div class="form-group">
            <label for="City">Kota</label>
            <input type="text" class="form-control" name="City" />
        </div>
        <div class="form-group">
            <label for="Email">Email</label>
            <input type="text" class="form-control" name="Email" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
