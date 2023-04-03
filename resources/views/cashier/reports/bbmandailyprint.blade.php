@extends('shared.print2')
@section('title', 'Print Laporan Barberman')
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
        <span>Laporan Barberman</span>
      </h2>
    </div>
    <div class="row invoice-info">
        <div class="col-xs-12">
            <div style="margin-top:10mm;padding-bottom:1mm;">
                <table>
                  <tr>
                      <td>Tanggal</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      <td>{{ $tanggal }}</td>
                  </tr>
                  <tr>
                      <td>Kode / Nama</td>
                      <td style="padding-left:5px;padding-right:10px;">:</td>
                      <td>{{ $barber->Kode }} - {{ $barber->Nama }}</td>
                  </tr>
                  <tr>
                      <td style="padding-top:5mm;"></td><td></td><td></td>
                  </tr>
                  @foreach($recap as $v)
                      <tr>
                          <td>{{ $v->ServiceName }}</td>
                          <td style="padding-left:5px;padding-right:10px;">:</td>
                          <td>{{ $v->Total }}</td>
                      </tr>
                  @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('/admin/plugins/jQuery/jquery-3.2.0.min.js') }}"></script>
<script src="{{ asset('/js/pages/transaction/print.js') }}"></script>
@endpush
