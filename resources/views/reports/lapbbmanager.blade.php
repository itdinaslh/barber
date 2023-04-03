@extends('shared.print2')
@section('title', 'Print Laporan Barberman')
@section('classcontent', 'invoice')
@push('styles')
<style>
@page { margin: 0; }
body {
    margin-left:0.5cm;
    margin-right:0.5cm;
    padding-left: 2mm;
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
        <span style="text-decoration:underline;">Laporan Fee Barberman</span>
      </h2>
    </div>
    <div class="row invoice-info">
        <div class="col-xs-12">
            <div style="margin-top:10mm;padding-bottom:1mm;">
                <table style="width:100%">
                  <tr>
                      <td style="width:35%;">Tanggal Awal</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      <td>{{ $first }}</td>
                      <td colspan="2"></td>
                  </tr>
                  <tr>
                      <td>Tanggal Akhir</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      <td>{{ $end }}</td>
                      <td colspan="2"></td>
                  </tr>
                  <tr>
                      <td>Jam Cetak</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      <td>{{ $hour }}</td>
                      <td colspan="2"></td>
                  </tr>
                  <tr style="border-bottom:1px solid black;">
                      <td style="padding-bottom:5px;">Kode / Nama</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      <td>{{ $barber->Kode }} - {{ $barber->Nama }}</td>
                  </tr>
                  <tr>
                      <td style="padding-top:2mm;"></td><td></td><td></td><td colspan="2"></td>
                  </tr>
                </table>
                <table style="width:100%">
                    @foreach($recap as $v)
                        <tr>
                            <td style="width:35%">{{ $v->ServiceName }}</td>
                            <td style="padding-left:5px;padding-right:10px;">:</td>
                            <td>{{ $v->Total }}</td>
                            <td style="width:20%"> x {{ $v->Fee }}</td>
                            <td>=</td>
                            <td style="text-align:right;">{{ $v->TotalFee }}</td>
                        </tr>
                    @endforeach
                    <tr style="border-bottom:1px solid black;">
                        <td colspan="6" style="padding-top:5px;"></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td style="text-align:right;padding-right:15px;">Total</td>
                        <td>=</td>
                        <td style="text-align:right">{{ $total }}</td>
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
