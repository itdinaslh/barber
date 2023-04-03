<form action="{{ url('/cost_op/editpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="did" value="{{ $disc->id }}">
    <input type="hidden" name="uid" value="{{ Auth::user()->username }}" />
    <input type="hidden" name="rPrice" id="rPrice" value="{{ $disc->Price }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Biaya Pengeluaran</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="Nama">Tanggal</label>
            <input type="text" id="tanggal" class="form-control tgl" value="{{ $disc->Tanggal }}" name="tanggal"
                autocomplete="off" required />
        </div>
        <div class="form-group">
            <label for="Nama">Nama Operasional</label>
            <select class="form-control" name="opID">
                @foreach ($data as $v)
                    <option value="{{ $v->id }}">{{ $v->NamaOp }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="Nama">Harga</label>
            <input type="text" id="Price" class="form-control" value="{{ $disc->Price }}" name="Price"
                autocomplete="off" required />
        </div>
        <div class="form-group">
            <label for="Nama">Qty</label>
            <input type="text" id="Qty" class="form-control" name="Qty" value="{{ $disc->Qty }}"
                autocomplete="off" required />
        </div>

        <div class="form-group">
            <label for="Nama">Keterangan</label>
            <input type="text" id="Ket" class="form-control" name="Ket" value="{{ $disc->Ket }}"
                autocomplete="off" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
