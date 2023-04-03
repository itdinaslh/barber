@extends('shared.master')
@section('title', 'Transaction Cafe')
@section('classcontent', 'content')
@section('PageHeader', 'Transaction Cafe')
@push('styles')
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.css') }}" />
@endpush

@section('content')
    <div class="row">
        <!-- <div class="col-xs-12">
            <div class="">
                <form id="FormNewTrans" class="" action="{{ url('/transaction/cafe/newtrans') }}" method="post">
                    {{ csrf_field() }}
                    <button type="submit" id="btnAddNew" class="btn btn-warning">New Transaction</button>
                </form>
            </div>
        </div> -->
        <!--Modal Window-->
        <div id='myModal' class='modal fade in'>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div id='myModalContent'></div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <img src="{{ asset('/img/logo-cafe.png') }}" alt="Logo-Cafe"
                style="margin-left:auto;margin-right:auto;width:450px;" class="img img-responsive" />
        </div>
        <div class="col-xs-12" style="margin-top:15px;">
            <form id="FormAddSubTrans" class="form-inline" action="/transaction/cafe/addsubtrans" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="">Pilih Produk</label>
                    <select id="ProdList" class="form-control" name="idprod" required>
                        @foreach ($prod as $v)
                            <option value="{{ $v->id }}">{{ $v->Nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Qty</label>
                    <input id="qtyprod" type="number" class="form-control" style="width:75px;" name="qty" required />
                </div>
                <div class="form-group">
                    <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
        <div id="newtrans" class="col-xs-12" style="margin-top:25px;">
            <div class="box">
                <div class="box-body">
                    <table id="transDetails" class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Produk</th>
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
        <div id="TotalTrans" class="col-xs-12">
            <div class="pull-right">
                {{-- <h3 style="font-weight:bold;font-size:36px;margin-top:0;color:blue; ">Total : Rp. <span id="TotalAll">{{ $Total }}</span>,-</h3> --}}
            </div>
        </div>
        <div class="col-xs-12" style="margin-top:50px;">
            <div class="pull-right">
                <div class="pull-right form-inline">
                    <div class="form-group">
                        <a href="{{ url('/transaction/cafe/print') }}" target="_blank" class="btn btn-warning">Print Struk
                            Terakhir</a>
                    </div>
                    <div class="form-group">
                        <form id="FormClearCart" action="{{ url('/transaction/cafe/clearcart') }}" method="post">
                            {{ csrf_field() }}
                            <button type="submit" id="btnClearTrans" name="btnClearTrans" class="btn btn-danger">Cancel
                                Transaksi</button>
                        </form>
                    </div>
                    <div class="form-group">
                        <button type="button" id="btnCheckOut" name="btnCheckOut" class="btn btn-info"
                            data-href="{{ url('/transaction/cafe/getcheckout') }}">Bayar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/admin/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/autonumeric/autoNumeric.min.js') }}"></script>
    <script src="{{ asset('/js/pages/cafe/modalCafe.js') }}"></script>
    <script src="{{ asset('/js/pages/cafe/trans.js') }}"></script>
@endpush
