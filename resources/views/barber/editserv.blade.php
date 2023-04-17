<form action="{{ url('/barberman/editservpost') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="bbservid" value="{{ $bbserv->id }}" />
    <input type="hidden" name="bbid" value="{{ $bbserv->BbID }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Data Service</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="ProductName">Service</label>
            <select class="form-control" name="ServiceID">
                @foreach ($serv as $v)
                    <option value="{{ $v->id }}" @if ($bbserv->ServiceID == $v->id) selected @endif>
                        {{ $v->ServiceName }}</option>
                @endforeach
            </select>
        </div>
        {{-- <div class="form-group">
            <label for="IdNum">Harga</label>
            <input type="number" class="form-control" value="{{ $bbserv->Harga }}" name="Harga" />
        </div> --}}
        <div class="form-group">
            <label for="Phone">Fee</label>
            <input type="number" class="form-control" value="{{ $bbserv->Fee }}" name="Fee" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
