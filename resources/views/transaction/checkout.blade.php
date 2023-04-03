<form id="formCheckout" action="{{ url('/transaction/checkout') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}" />
    <input type="hidden" id="totalhid" name="totalhid" value="{{ $TotalHid }}" />
    <input type="hidden" id="rDisc" name="rDisc" value="0" />
    <input type="hidden" id="rVoucher" name="rVoucher" value="0">
    <input type="hidden" id="rTotal" name="rTotal" value="{{ $TotalHid }}" />
    <input type="hidden" id="rPayVal" name="rPayVal" value="0">
    <input type="hidden" name="trx" value="{{ $trans->id }}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                class="sr-only">Close</span></button>
        <h4 class="modal-title">Checkout Transaksi</h4>
    </div>
    <div class="modal-body">
        <div class="col-md-6 col-xs-12">
            <div class="form-group">
                <label for="TrxID">Trx ID</label>
                <input type="text" id="TrxID" class="form-control" name="TrxID" value="{{ $trans->id }}"
                    disabled />
            </div>
            <div class="form-group">
                <label for="CustName">Customer</label>
                <input type="text" class="form-control" name="CustName" value="{{ $trans->Nama }}" disabled />
            </div>
            <div class="form-group">
                <label for="IdNum">Total Transaksi</label>
                <input type="text" id="TotalTrans" class="form-control" name="TotalTrans" value="{{ $TotalString }}"
                    disabled />
            </div>
            <div class="form-group">
                <label for="IdNum">DiscountID</label>
                <input id="DiscountID" type="text" maxlength="9" class="form-control" name="DiscountID"
                    autocomplete="off" autofocus />
            </div>
            <div class="form-group">
                <label for="IdNum">Discount</label>
                <input id="Discount" type="text" class="form-control" name="Discount" autocomplete="off" disabled />
            </div>
            <div class="form-group">
                <label for="IdNum">Voucher ID</label>
                <input id="VoucherID" type="text" class="form-control" maxlength="9" autocomplete="off"
                    name="VoucherID" />
            </div>
            <div class="form-group">
                <label for="IdNum">Nilai Voucher</label>
                <input id="VoucherVal" type="text" class="form-control" name="VoucherVal" disabled />
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="form-group">
                <label for="IdNum">Total</label>
                <input id="SubtotalTrx" type="text" class="form-control" value="{{ $TotalString }}"
                    name="SubtotalTrx" disabled />
            </div>
            <div class="form-group">
                <label for="IdNum">Payment Method</label>
                <select id="payment" class="form-control" name="PaymentID">
                    @foreach ($payment as $p)
                        <option value="{{ $p->id }}">{{ $p->Name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="IdNum">Uang Bayar</label>
                <input id="PayVal" type="text" class="form-control" name="PayVal" autocomplete="off"
                    required />
            </div>
            <div id="ChangeView" class="form-group">
                <label for="IdNum">Uang Kembali</label>
                <input id="Change" type="text" class="form-control" name="Change" disabled />
            </div>
            <div id="CardView" class="form-group" style="display:none;">
                <label for="IdNum">No Kartu</label>
                <input id="CardID" type="text" class="form-control" name="CardID" />
            </div>
            <div class="form-group">
                <div class="text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Bayar</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer" style="border-top:none;">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Bayar</button> -->
    </div>
</form>
