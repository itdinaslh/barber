@extends('shared.print2')
@section('title', 'Print Laporan Rekap')
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
</style>
@endpush

@section('content')
    <div class="col-xs-12" style="margin-top:4mm;">
      <h2 class="page-header" style="padding-bottom:0;border-bottom:none;margin-bottom:0;text-align:center">
        <span>Rekap Pendapatan</span>
      </h2>
    </div>
    <div class="row invoice-info">
        <div class="col-xs-12">
            <div style="margin-top:10mm;padding-bottom:1mm;">
                <table>
                  <tr>
                      <td>Tanggal</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      <td>{{ $first }} - {{ $end }}</td>
                  </tr>
                  <tr>
                      <td style="padding-top:5mm;"></td><td></td><td></td>
                  </tr>
                  <tr>
                      <td>Cash</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      <td>{{ $recap->Cash }}</td>
                  </tr>
                  <tr>
                      <td>Voucher</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      <td>{{ $recap->Voucher }}</td>
                  </tr>
                  <tr>
                      <td>Discount</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      <td>{{ $recap->Discount }}</td>
                  </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('/admin/plugins/jQuery/jquery-3.2.0.min.js') }}"></script>
<script src="{{ asset('/js/pages/transaction/print.js') }}"></script>
@endpush
