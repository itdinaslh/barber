<form action="{{ url('/barberman/editpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}" />
    <input type="hidden" name="id" value="{{ $bb->id }}">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Data Barberman</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="ProductName">Nama Barberman</label>
            <input type="text" class="form-control uppercase" name="Nama" value="{{ $bb->Nama }}" required />
        </div>
        <div class="form-group">
            <label for="IdNum">No. Identitas</label>
            <input type="number" class="form-control" maxlength="16" value="{{ $bb->IdNum }}" name="IdNum" />
        </div>
        <div class="form-group">
            <label for="Phone">Telp</label>
            <input type="text" class="form-control" value="{{ $bb->Phone }}" name="Phone" />
        </div>
        <div class="form-group">
            <label for="Level">Level</label>
            <select class="form-control" name="Level">
                <option value="S" @if($bb->Level == 'S')selected @endif>Senior</option>
                <option value="M" @if($bb->Level == 'M')selected @endif>Madya</option>
                <option value="J" @if($bb->Level == 'J')selected @endif>Junior</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
