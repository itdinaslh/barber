@extends('shared.print2')
@section('title', 'Print Struk')
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
    margin-left:-4mm;
    padding-left:1mm;
    width: 100%;
    padding-right:1mm;
    font-size: 10px;
    text-align: center;
}
#note {
    margin-left:auto;
    margin-right:auto;
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
    <h2 class="page-header" style="padding-bottom:0;border-bottom:none;margin-bottom:0;padding-left:15mm">
      <img src="{{ asset('/img/logo-small.png')}}" class="img img-responsive logo" style="float:left" alt="" />
      <span style="float:left;margin-left:5px;">NM Barbershop</span>
    </h2>
  </div>
<div class="row invoice-info">
    <div class="col-xs-12">
      <div style="padding-bottom:1mm;text-align:center;border-bottom:1px solid black;">
          it's more than just a hair cut <br />
          Kenconowungu Tengah I / 1 Semarang-Barat<br />
          fb : ................ / instagram : ........... <br />
          Tlp / Wa : 0821 3369 5417
      </div>
      <div style="margin-top:0;border-bottom:1px solid black;padding-bottom:1mm;">
          <table>
            <tr>
                <td>No. Trx</td>
                <td style="padding-left:5px;padding-right:10px;">:</td>
                <td>{{ $trans->id }}</td>
            </tr>
            <tr>
                <td>Tgl</td>
                <td style="padding-left:5px;padding-right:10px;">:</td>
                <td>{{ $trans->created_at }}</td>
            </tr>
            <tr>
                <td>Customer</td>
                <td style="padding-left:5px;padding-right:10px;">:</td>
                <td>{{ $trans->CustName }} - {{ $trans->CustID }}</td>
            </tr>
          </table>
      </div>
      <div style="font-size:12px; margin-top:0;">
          <table id="detail" style="width:100%;">
            <thead>
                <tr>
                  <th class="head" style="width:7%">No</th>
                  <th class="head" style="width:55%">Service/Product</th>
                  <th class="head" style="width:8%">Qty</th>
                  <th class="head" style="text-align:right;width:30%;">Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach($detail as $v)
                    <tr>
                        <td>{{ $i++ }}.</td>
                        <td>{{ $v->ServiceName }}</td>
                        <td>{{ $v->Qty }}</td>
                        <td style="text-align:right;">{{ $v->SubTotal }}</td>
                    </tr>
                @endforeach
                @foreach($prod as $v)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $v->ProductName }}</td>
                        <td>{{ $v->Qty }}</td>
                        <td style="text-align:right;">{{ $v->Total }}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
          <div style="text-align:right;">- - - - - - - - - - - - - - - - - - - - - - - - -</div>
          <table style="width:100%;margin-top:1mm;">
              <tbody>
                  <tr>
                      <td style="width:5%"></td>
                      <td style="width:40%"></td>
                      <td style="width:10%"></td>
                      <td>Jumlah</td>
                      <td style="text-align:right">{{ $trans->TotalTrx }}</td>
                  </tr>
                  <tr>
                      <td colspan="3"></td>
                      <td>Discount</td>
                      <td style="text-align:right">{{ $trans->Discount }}</td>
                  </tr>
                  <tr>
                      <td colspan="3"></td>
                      <td>Voucher</td>
                      <td style="text-align:right">{{ $trans->VoucherVal }}</td>
                  </tr>
              </tbody>
          </table>
          <div style="text-align:right;">- - - - - - - - - - - - - - - - - - - - - - - - -</div>
          <table style="width:100%;">
            <tbody>
              <tr>
                  <td style="width:5%"></td>
                  <td style="width:40%"></td>
                  <td style="width:10%"></td>
                  <td>Grand Total</td>
                  <td style="text-align:right">{{ $trans->TotalPaid }}</td>
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
          <div style="text-align:right;">- - - - - - - - - - - - - - - - - - - - - - - - -</div>
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
          <div id="note" class="">
              {!! $note->Content !!}
              <div class="">
                  Terima kasih atas kunjungan anda
              </div>
          </div>
      </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('/admin/plugins/jQuery/jquery-3.2.0.min.js') }}"></script>
<script src="{{ asset('/js/pages/transaction/print.js') }}"></script>
@endpush
