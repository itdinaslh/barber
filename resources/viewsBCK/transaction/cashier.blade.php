@extends('shared.master')
@section('title', 'All Transaction')
@section('classcontent', 'content')
@section('PageHeader', 'All Transaction')
@push('styles')
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.css') }}" />
@endpush

@section('content')
    <!--Modal Window-->
    <div id='myModal' class='modal fade in'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id='myModalContent'></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="col-md-6 col-xs-12">
                        <form class="form-inline">
                            <div class="form-group">
                                <label for="">Select Transaction</label>
                                <select id="trxdropdown" class="form-control" name="">
                                    @foreach ($data as $v)
                                        <option value="{{ $v->id }}" data-member="{{ $v->MemberID }}">
                                            {{ $v->MemberID }} - {{ $v->Nama }} ( {{ $v->created_at }} )</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="pull-right">
                            <button type="button" class="btn btn-warning showMe"
                                data-href="{{ url('/customer/getorder') }}" name="button">New Transaction</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="detailDiv" class="col-xs-12" style="display:none;">
            <div class="box">
                <div class="box-header">
                    <h3 id="DetailTitle" class="box-title">Detail Transaksi</h3>
                    <strong><span class="pull-right" id="TotalTrx">Total : 0</span></strong>
                </div>
                <div class="box-body">
                    <div class="col-md-6 col-xs-12">
                        <form id="formService" class="form-inline" action="/transaction/addtransbbdetail" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" id="TrxID" name="TrxID" value="">
                            <div class="form-group">
                                <label for="ServiceID">Service</label>
                                <select class="form-control" name="ServiceID" id="sid" required>
                                    @foreach ($serv as $s)
                                        <option value="{{ $s->id }}">{{ $s->ServiceName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bid">Barber</label>
                                <select class="form-control" name="BbID" id="bid" required>
                                    @foreach ($barber as $b)
                                        <option value="{{ $b->id }}">{{ $b->Nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Qty">Qty</label>
                                <input type="number" class="form-control" name="Qty" value="1" min="1"
                                    max="100" />
                            </div>
                            <button type="submit" class="btn btn-success" id="btnAddBB" style="width:100px;">Add</button>
                        </form>
                    </div>
                    <div class="col-md-6 col-xs-12" style="margin-bottom:25px;">
                        <form id="formProduct" class="form-inline" action="/transaction/addtransbbproduct" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" id="TrxProduct" name="TrxProduct" value="">
                            <div class="form-group">
                                <label for="">Product</label>
                                <select class="form-control" name="ProductID">
                                    @foreach ($product as $v)
                                        <option value="{{ $v->id }}">{{ $v->ProductName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bid">Barber</label>
                                <select class="form-control" name="BbID" required>
                                    @foreach ($barber as $b)
                                        <option value="{{ $b->id }}">{{ $b->Nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Qty">Qty</label>
                                <input type="number" class="form-control" name="Qty" value="1" min="1"
                                    max="100" />
                            </div>
                            <button type="submit" class="btn btn-success" id="btnAddProduct"
                                style="width:100px;">Add</button>
                        </form>
                    </div>

                    <div id="transdetail">
                        <table id="trxDetail" class="table table-responsive table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Service/Product</th>
                                    <th>Bbman</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="pull-right">
                    <button id="btnCheckOut" type="button" name="btnCheckOut" class="btn btn-info showMe"
                        data-href="/transaction/getcheckout-">Bayar</button>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/admin/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/autonumeric/autoNumeric.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('/admin/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('/admin/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <script src="{{ asset('/js/pages/transaction/modalTrans.js') }}"></script>
    <script src="{{ asset('/js/pages/transaction/cashier.js') }}"></script>
@endpush
