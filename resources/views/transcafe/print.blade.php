@extends('shared.print2')
@section('title', 'Print Struk Cafe')
@section('classcontent', 'invoice')
@push('styles')
<style>
@page { margin: 0; }
body {
  margin-left:0.5cm;
  margin-right:0.5cm;
  width: 95mm;
  height: 140mm;
  font-size: 11px;
  padding-left: 5mm;
}
.head { font-weight: normal; text-align: left;}
#detail tr td { font-weight: normal;}
.separator { padding-top: 10px;}
#foot {
  position: fixed;
  width: 95mm;
  bottom: 5mm;
  font-size: 10px;
  text-align: center;
}
.logo {
  width: 25px;
  height: 25px;
  float:left;
}
</style>
@endpush

@section('content')
<div class="row">
  <div class="col-xs-12 myCenter" style="margin-top:2mm;">
    <div style="padding-left:33mm;">
        <img src="{{ asset('/img/logo-small.png') }}" class="img img-responsive logo" alt="" />
        <span style="float:left;margin-left:2mm;font-size:14px;font-weight:bold;">NM Cafe</span>
    </div>
  </div>
</div>
<div class="row invoice-info">
    <div class="col-xs-12">
      <div style="padding-bottom:1mm;text-align:center;border-bottom:1px solid black;font-size:9pt;">
        Kenconowungu Tengah I / No. 1 Semarang-Barat<br />
        fb : nm.barbershop17 / instagram : @nm.barbershop <br />
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
      <div style="margin-top:0;">
          <table id="detail" style="width:100%;">
            <thead>
                <tr>
                  <th class="head" style="width:5%;">No</th>
                  <th class="head" style="width:50%;padding-left:1mm;">Produk</th>
                  <th class="head" style="width:5%">Qty</th>
                  <th class="head" style="width:20%;padding-left:3mm;">Harga</th>
                  <th class="head" style="text-align:right;width:20%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach($data as $v)
                    <tr>
                        <td>{{ $i++ }}.</td>
                        <td style="padding-right:1mm;padding-left:1mm;">{{ $v->Nama }}</td>
                        <td>{{ $v->Qty }}</td>
                        <td style="padding-left:3mm;">{{ $v->Harga }}</td>
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
                  <td>Total</td>
                  <td style="text-align:right">{{ $trans->Total }}</td>
              </tr>
              <tr>
                  <td colspan="3"></td>
                  <td>Discount</td>
                  <td style="text-align:right">{{ $trans->Discount }}</td>
              </tr>
              <tr>
                  <td colspan="3"></td>
                  <td>Grand Total</td>
                  <td style="text-align:right">{{ $gt }}</td>
              </tr>
              <tr>
                  <td colspan="3"></td>
                  <td>Dibayar</td>
                  <td style="text-align:right">{{ $trans->PayVal }}</td>
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
          *** Terima Kasih ***
      </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('/admin/plugins/jQuery/jquery-3.2.0.min.js') }}"></script>
<script src="{{ asset('/js/pages/transaction/print.js') }}"></script>
@endpush
