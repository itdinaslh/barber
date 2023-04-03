@extends('shared.print')
@section('title', 'Print Struk')
@section('classcontent', 'invoice')
@section('PageHeader', 'Print Struk')
@push('styles')

@endpush

@section('content')
<div class="row">
  <div class="col-xs-12">
    <h2 class="page-header">
      <i class="fa fa-globe"></i> My Brother Haircare
      <small class="pull-right">Tanggal: {{ $trans->created_at }}</small>
    </h2>
  </div>
  <!-- /.col -->
</div>

<div class="row">
    <div class="col-xs-12 table-responsive">
        <table>
            <tr>
                <td style="padding-right:20px;">Transaction ID</td>
                <td style="padding-right:15px;">:</td>
                <td>{{ $trans->id }}</td>
            </tr>
            <tr>
                <td>Chashier</td>
                <td>:</td>
                <td>{{ $trans->name }}</td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>:</td>
                <td>{{ $trans->MemberID }} - {{ $trans->Nama }}</td>
            </tr>
        </table>
        <br /><br />
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Service</th>
                    <th>Jml</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody>
                @foreach($details as $v)
                  <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $v->ServiceName }} ({{ $v->Kode }})</td>
                    <td>{{ $v->Qty}}</td>
                    <td>{{ $v->Price }}</td>
                    <td>{{ $v->SubTotal }}</td>
                  </tr>
                @endforeach
                @foreach($prod as $v)
                  <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $v->ProductName }} ({{ $v->Kode }})</td>
                    <td>{{ $v->Qty}}</td>
                    <td>{{ $v->Price }}</td>
                    <td>{{ $v->Total }}</td>
                  </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        <p class="lead">Payment Methods:</p>
        <img src="{{ asset('/admin/dist/img/credit/visa.png') }}" alt="Visa">
        <img src="{{ asset('/admin/dist/img/credit/mastercard.png') }}" alt="Mastercard">
        <img src="{{ asset('/admin/dist/img/credit/mestro.png') }}" alt="American Express">

        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          Terima kasih atas kepercayaan anda menggunakan jasa kami. <br />
        </p>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">Total Transaksi</p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Total</th>
              <td>Rp. {{ $trans->TotalTrx }}</td>
            </tr>
            <tr>
              <th>Disc Total</th>
              <td>(Rp. {{ $trans->Discount }})</td>
            </tr>
            <tr>
              <th>Voucher</th>
              <td>(Rp. {{ $trans->VoucherVal }})</td>
            </tr>
            <tr>
              <th>Grand Total</th>
              <td style="color:red;">Rp. {{ $trans->TotalPaid }}</td>
            </tr>
            <tr>
              <th>Payment</th>
              <td>{{ $trans->PayMethod }}</td>
            </tr>
            <tr>
              <th>Dibayar</th>
              <td style="color:blue;">Rp. {{ $trans->PayVal }}</td>
            </tr>
            <tr>
              <th>Kembali</th>
              <td style="color:green;">Rp. {{ $change }}</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <div class="row no-print">
      <div class="col-xs-12">
        <a href="/transaction/struk/{{ $trans->id }}" class="btn btn-primary pull-right"><i class="fa fa-print"></i> Print Struk</a>
      </div>
    </div>
</div>
@endsection
