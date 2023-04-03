@extends('shared.master')
@section('title', 'Biaya Pengeluaran')
@section('classcontent', 'content')
@section('PageHeader', 'Biaya Pengeluaran')
@push('styles')
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datepicker/datepicker3.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.css') }}" />
@endpush

@section('content')

    <!--Modal Window-->
    <div id='myModal' class='modal fade in'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div id='myModalContent'></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="text-right">
                        <button type="button" name="btnAdd" class="btn btn-primary showMe"
                            data-href="{{ url('/cost_op/add') }}">Add New</button>
                    </div>
                </div>
                <div class="box-body">
                    <table id="cost_op" class="table table-bordered table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Nama Operasional</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Laporan Biaya Pengeluaran</h3>
                </div>
                <div class="box-body">
                    <form id="formreports" class="form-inline" action="{{ url('/cashier/reports/laprecapget') }}"
                        method="get" style="margin-top:30px;margin-bottom:30px;">
                        <div class="form-group">
                            <label for="">Tanggal Awal</label>
                            <input type="text" id="TglAwal" class="form-control tgl" name="TglAwal" autocomplete="off"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Akhir</label>
                            <input type="text" id="TglAkhir" class="form-control tgl" name="TglAkhir" autocomplete="off"
                                required />
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
                                <th>Tanggal</th>
                                <th>Nama Operasional</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="col-xs-12 text-right form-inline" style="padding-right:0;margin-top:15px;">
                        <div class="form-group">
                            <form id="formprint" action="{{ url('/reports/print') }}" method="post">
                                <button type="submit" name="button" class="btn">Print Report</button>
                            </form>
                        </div>
                        {{-- <div class="form-group">
                            <form id="formpdf" action="{{ url('/reports/bbspdf') }}" method="post">
                                <button type="submit" class="btn btn-danger" name="button">Download PDF</button>
                            </form>
                        </div> --}}
                        <div class="form-group">
                            <form id="formexcel" action="{{ url('/reports/bbsexcel') }}" method="post">
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
                                <td>Total Income Barbershop</td>
                                <td>:</td>
                                <td style="background-color:green;color:white"><span id="SumTotalPaid"></span></td>
                            </tr>
                            <tr>
                                <td style="width:30%">Total Cost</td>
                                <td style="padding-right:8px;">:</td>
                                <td style="background-color:red;color:white;"><span id="SumTotalTrx"></span></td>
                            </tr>
                            <tr>
                                <td>Total </td>
                                <td>:</td>
                                <td style="background-color:rgb(37, 6, 139);color:white"><span id="result"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/admin/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('/admin/plugins/autonumeric/autoNumeric.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/js/pages/cost_op/modalOp.js') }}"></script>
    <script src="{{ asset('/js/pages/cost_op/index.js') }}"></script>
@endpush
