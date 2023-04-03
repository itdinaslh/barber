@extends('shared.print2')
@section('title', 'Print Struk Cafe')
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
    bottom: 4mm;
    width: 100%;
    font-size: 10px;
    text-align: center;
}
</style>
@endpush

@section('content')

<div class="col-xs-12" style="margin-top:4mm;">
  <h2 class="page-header" style="padding-bottom:0;border-bottom:none;margin-bottom:0;text-align:center">
    <span style="">Laporan Transaksi</span>
  </h2>
</div>
<div class="col-xs-12">
    <table class="table table-responsive table-striped table-bordered">
        <thead>
            <tr>
                <th>Tgl</th>
                <th>Trx ID</th>
                <th>Total Trx</th>
                <th>DiscountID</th>
                <th>Discount (Rp)</th>
                <th>VoucherID</th>
                <th>Voucher (Rp)</th>
                <th>Payment</th>
                <th>Total Paid</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{ $v->tgl }}</td>
                    <td>{{ $v->TrxID }}</td>
                    <td>{{ $v->TotalTrx }}</td>
                    <td>{{ $v->DiscountID }}</td>
                    <td>{{ $v->Discount }}</td>
                    <td>{{ $v->VoucherID }}</td>
                    <td>{{ $v->VoucherVal }}</td>
                    <td>{{ $v->PayMethod }}</td>
                    <td>{{ $v->TotalPaid }}</td>
                </tr>
            @endforeach
                <tr style="border:none;">
                    <td colspan="2"></td>
                    <td>{{ $SumTrx }}</td>
                    <td style="border:none;"></td>
                    <td>{{ $SumDiscount }}</td>
                    <td></td>
                    <td>{{ $SumVoucher }}</td>
                    <td></td>
                    <td>{{ $SumPaid }}</td>
                </tr>
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script src="{{ asset('/admin/plugins/jQuery/jquery-3.2.0.min.js') }}"></script>
<script src="{{ asset('/js/pages/transaction/print.js') }}"></script>
@endpush
