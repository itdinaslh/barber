@extends('shared.master')
@section('title', 'Transaction Reports')
@section('classcontent', 'content')
@section('PageHeader', 'Transaction Reports (Cafe)')
@push('styles')
  <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/datatables.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/datepicker/datepicker3.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/pivot/pivot.min.css') }}" />
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
                    <form id="formreports" class="form-inline" action="{{ url('/reports/lapcafeget')}}" method="get" style="margin-top:30px;margin-bottom:30px;">
                         <div class="form-group">
                              <label for="">Tanggal Awal</label>
                              <input type="text" id="TglAwal" class="form-control tgl" name="TglAwal" autocomplete="off" required/>
                         </div>
                         <div class="form-group">
                              <label for="">Tanggal Akhir</label>
                              <input type="text" id="TglAkhir" class="form-control tgl" name="TglAkhir" autocomplete="off" required/>
                         </div>
                         <div class="form-group">
                              <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-success">Submit</button>
                         </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-12 transhid" style="display:none;">
            <div class="box">
                <div class="box-body">
                    <table class="table table-responsive table-striped table-hover table-bordered" id="trans">
                        <thead>
                            <tr>
                                <th>Tgl</th>
                                <th>Trx ID</th>
                                <th>Payment Type</th>
                                <th>Sub Total</th>
                                <th>Discount</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="col-xs-12 text-right form-inline" style="padding-right:0;margin-top:15px;">
                        <div class="form-group">
                            <form id="formprint" action="{{ url('/reports/cafe/print') }}" method="post">
                                <button type="submit" name="button" class="btn">Print Report</button>
                            </form>
                        </div>
                        <div class="form-group">
                            <form id="formpdf" action="{{ url('/reports/cafe/exportpdf') }}" method="post">
                                  <button type="submit" class="btn btn-danger" name="button">Download PDF</button>
                            </form>
                        </div>
                        <div class="form-group">
                            <form id="formexcel" action="{{ url('/reports/cafe/exportexcel') }}" method="post">
                                  <button type="submit" name="button" class="btn btn-success">Download Excel</button>
                            </form>
                        </div>
                    </div>
                    <div class="" style="margin-top:25px;">
                        <h3>Rekapitulasi</h3>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <td style="width:30%">Total Transaksi</td>
                                <td style="padding-right:8px;">:</td>
                                <td style="background-color:red;color:white;"><span id="SumTotalTrx"></span></td>
                            </tr>
                            <tr>
                                <td style="width:30%">Total Discount</td>
                                <td style="padding-right:8px;">:</td>
                                <td><span id="SumDiscount"></span></td>
                            </tr>
                            <tr>
                                <td style="width:30%">Total Income Cafe</td>
                                <td style="padding-right:8px;">:</td>
                                <td style="background-color:green;color:white;"><span id="GrandTotal"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 transhid" style="display:none;overflow-x:auto;">
            <div class="box">
                <div class="box-body">
                    <div class="">
                        <h3>Pivot Report Cafe Details</h3>
                    </div>
                    <div class="alert alert-info" role="alert">
                        Drag & drop komponen untuk mencari hasil yang diinginkan. Fungsi sama dengan Pivot Table pada Excel
                    </div>
                    <div id="pivot" style="margin-top:25px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
  <script src="{{ asset('/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/pivot/pivot.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('/js/pages/reports/cafe.js') }}"></script>
@endpush
