@extends('shared.print2')
@section('title', 'Print Struk Cafe')
@section('classcontent', 'invoice')
@push('styles')
<style>
@page { margin: 0; }
body {
    margin-left:0.5cm;
    margin-right:0.5cm;
}
.head { font-weight: normal; text-align: left;}
#detail tr td { font-weight: normal;}
.separator { padding-top: 10px;}
#foot {
    position: fixed;
    bottom: 2mm;
    width: 100%;
    font-size: 10px;
    text-align: center;
}
.logo {
    width: 25px;
    height: 25px;
}
</style>
@endpush

@section('content')
<div class="col-xs-12" style="margin-top:0.3mm;">
  <h2 class="page-header" style="padding-bottom:0;border-bottom:none;margin-bottom:0;padding-left:22mm">
    <img src="{{ asset('/img/logo-small.png')}}" class="img img-responsive logo" style="float:left" alt="" />
    <span style="float:left;margin-left:5px;">NM Cafe</span>
  </h2>
</div>
<div class="row invoice-info">
    <div class="col-xs-12">
      <div style="padding-bottom:1mm;text-align:center;border-bottom:1px solid black;">
        Kenconowungu Tengah I / 1 Semarang-Barat<br />
        fb : ................ / instagram : ........... <br />
        Tlp / Wa : 0821 3369 5417
      </div>
      <div style="margin-top:0;border-bottom:1px solid black;padding-bottom:1mm;">
          <table>
            <tr>
                <td>No. Trx</td>
                <td style="padding-left:5px;padding-right:10px;">:</td>
                <td>{{ $trans->id }} [ {{ $trans->created_at }} ]</td>
            </tr>
            <tr>
                <td>Cashier</td>
                <td style="padding-left:5px;padding-right:10px;">:</td>
                <td>{{ $trans->usercode }} - {{ $trans->username }}</td>
            </tr>
          </table>
      </div>
      <div style="font-size:12px; margin-top:0;">
          <table id="detail" style="width:100%;">
            <thead>
                <tr>
                  <th class="head" style="width:5%">No</th>
                  <th class="head" style="width:40%">Produk</th>
                  <th class="head" style="width:10%">Qty</th>
                  <th class="head" style="width:15%">Harga</th>
                  <th class="head" style="text-align:right;width:30%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach($data as $v)
                    <tr>
                        <td>{{ $i++ }}.</td>
                        <td>{{ $v->Nama }}</td>
                        <td>{{ $v->Qty }}</td>
                        <td>{{ $v->Harga }}</td>
                        <td style="text-align:right;">{{ $v->Subtotal }}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
          <div style="text-align:right;">- - - - - - - - - - - - - - - - - - - - - - (+)</div>
          <table style="width:100%;">
            <tbody>
              <tr>
                  <td style="width:5%"></td>
                  <td style="width:40%"></td>
                  <td style="width:10%"></td>
                  <td>Grand Total</td>
                  <td style="text-align:right">{{ $trans->Total }}</td>
              </tr>
              <tr>
                  <td colspan="3"></td>
                  <td>Dibayar</td>
                  <td style="text-align:right">{{ $trans->PayVal }}</td>
              </tr>
              <tr>
                  <td colspan="3"></td>
                  <td>Payment</td>
                  <td style="text-align:right"></td>
              </tr>
              <tr>
                  <td colspan="3"></td>
                  <td style="font-decoration:italic;">{{ $trans->PayMethod }}</td>
                  <td style="text-align:right"></td>
              </tr>
            </tbody>
          </table>
          <div style="text-align:right;">- - - - - - - - - - - - - - - - - - - - - - (+)</div>
          <table style="width:100%;">
              <tbody>
                <tr>
                    <td style="width:5%"></td>
                    <td style="width:40%"></td>
                    <td style="width:10%"></td>
                    <td>Kembali</td>
                    <td style="text-align:right">{{ $change }}</td>
                </tr>
              </tbody>
          </table>
      </div>
      <div id="foot">
          note : transaksi anda telah tercatat dalam undian <br />
          Terima Kasih <br />
      </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('/admin/plugins/jQuery/jquery-3.2.0.min.js') }}"></script>
<script src="{{ asset('/js/pages/transaction/print.js') }}"></script>
@endpush
