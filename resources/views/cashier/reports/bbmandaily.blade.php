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
                    <form id="CashierDaily" class="form-inline" action="{{ url('/cashier/reports/lapbbmanpost')}}" method="get">
                        <div class="form-group">
                             <label for="">Tanggal</label>
                             <input type="text" id="Tanggal" class="form-control tgl" value="{{ $date }}" name="tanggal" disabled autocomplete="off" required/>
                        </div>
                        <div class="form-group">
                             <label for="">Kode Barberman</label>
                             <select id="barberman" class="form-control" name="BbID" required>
                                 @foreach($data as $v)
                                     <option value="{{ $v->id }}">{{ $v->Kode }} - {{ $v->Nama }}</option>
                                 @endforeach
                             </select>
                        </div>
                        <div class="form-group">
                             <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-success">Submit</button>
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
