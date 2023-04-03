<form id="formCheckout" action="{{ url('/transaction/cafe/checkout') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}" />
    <input type="hidden" id="totalhid" name="totalhid" value="{{ $TotalHid }}" />
    <input type="hidden" id="rTotal" name="rTotal" value="{{ $TotalHid }}" />
    <input type="hidden" id="rDisc" name="rDisc" value="0" />
    <input type="hidden" id="rPayVal" name="rPayVal" value="0" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Checkout Transaksi Cafe</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="IdNum">Total</label>
            <input type="text" id="TotalTrans" class="form-control" name="TotalTrans" value="Rp. {{ $TotalString }},-" disabled />
        </div>
        <div class="form-group">
            <label for="IdNum">Payment Method</label>
            <select id="payment" class="form-control" name="PaymentID">
                @foreach($payment as $p)
                    <option value="{{ $p->id }}">{{ $p->Name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="IdNum">Discount</label>
            <input id="Discount" type="text" class="form-control" name="Discount" autocomplete="off" autofocus />
        </div>
        <div class="form-group">
            <label for="IdNum">Uang Bayar</label>
            <input id="PayVal" type="text" class="form-control" name="PayVal" autocomplete="off" required />
        </div>
        <div id="ChangeView" class="form-group">
            <label for="IdNum">Uang Kembali</label>
            <input id="Change" type="text" class="form-control" name="Change" disabled />
        </div>
        <div id="CardView" class="form-group" style="display:none;">
            <label for="IdNum">No Kartu</label>
            <input id="CardID" type="text" class="form-control" name="CardID" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Bayar</button>
    </div>
</form>
