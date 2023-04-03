@extends('shared.master')
@section('title', 'Laporan Barberman')
@section('classcontent', 'content')
@section('PageHeader', 'Laporan Barberman')
@push('styles')
  <link rel="stylesheet" href="{{ asset('/admin/plugins/datepicker/datepicker3.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.css') }}" />
  <style media="screen">
      .left {
          padding-left: 10px;
      }
  </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="">
                        <h2>Print Laporan Barberman</h2>
                    </div>
                    <form id="formlapbbman" class="form-inline" action="{{ url('/cashier/reports/lapbbmanpost')}}" method="get" style="margin-top:30px;margin-bottom:30px;">
                         <div class="form-group">
                              <label for="">Tanggal Awal</label>
                              <input type="text" id="TglAwal" class="form-control tgl" name="TglAwal" autocomplete="off" required/>
                         </div>
                         <div class="form-group">
                              <label for="">Tanggal Akhir</label>
                              <input type="text" id="TglAkhir" class="form-control tgl" name="TglAkhir" autocomplete="off" required/>
                         </div>
                         <div class="form-group">
                              <label for="">Kode Barberman</label>
                              <select id="barberman" class="form-control" name="BbID" required>
                                  <option value="0">All</option>
                                  @foreach($data as $v)
                                      <option value="{{ $v->id }}">{{ $v->Kode }} - {{ $v->Nama }}</option>
                                  @endforeach
                              </select>
                         </div>
                         <div class="form-group">
                              <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-success">Print</button>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="">
                        <h2>Print Laporan Fee Barberman</h2>
                    </div>
                    <form id="formlapmanager" class="form-inline" action="{{ url('/cashier/reports/lapbbmanpost')}}" method="get" style="margin-top:30px;margin-bottom:30px;">
                         <div class="form-group">
                              <label for="">Tanggal Awal</label>
                              <input type="text" id="tAwal" class="form-control tgl" name="TglAwal" autocomplete="off" required/>
                         </div>
                         <div class="form-group">
                              <label for="">Tanggal Akhir</label>
                              <input type="text" id="tAkhir" class="form-control tgl" name="TglAkhir" autocomplete="off" required/>
                         </div>
                         <div class="form-group">
                              <label for="">Kode Barberman</label>
                              <select id="bbman" class="form-control" name="BbID" required>
                                  @foreach($data as $v)
                                      <option value="{{ $v->id }}">{{ $v->Kode }} - {{ $v->Nama }}</option>
                                  @endforeach
                              </select>
                         </div>
                         <div class="form-group">
                              <button type="submit" name="btnSubmit" id="btnSubmitManager" class="btn btn-warning">Print</button>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
  <script src="{{ asset('/admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('/js/pages/cashier/lapbbman.js') }}"></script>
@endpush
