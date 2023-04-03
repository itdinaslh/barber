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
        <span style="text-decoration:underline;">Laporan Barberman</span>
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
                  </tr>
                  <tr>
                      <td>Tanggal Akhir</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      <td>{{ $end }}</td>
                  </tr>
                  <tr>
                      <td>Jam Cetak</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      <td>{{ $hour }}</td>
                  </tr>
                  <tr style="border-bottom:1px solid black;">
                      <td style="padding-bottom:5px;">Kode / Nama</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      @if($id == 0)
                          <td>All</td>
                      @else
                          <td>{{ $barber->Kode }} - {{ $barber->Nama }}</td>
                      @endif
                  </tr>
                  <tr>
                      <td style="padding-top:2mm;"></td><td></td><td></td>
                  </tr>
                  @foreach($recap as $v)
                      <tr>
                          <td>{{ $v->ServiceName }}</td>
                          <td style="padding-left:5px;padding-right:10px;">:</td>
                          <td>{{ $v->Total }}</td>
                      </tr>
                  @endforeach
                </table>
                <hr style="border-top:1px solid black" />
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('/admin/plugins/jQuery/jquery-3.2.0.min.js') }}"></script>
<script src="{{ asset('/js/pages/transaction/print.js') }}"></script>
@endpush
