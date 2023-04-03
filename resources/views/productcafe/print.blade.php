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
    <span style="">List Data Product Cafe</span>
  </h2>
</div>
<div class="col-xs-12">
    <table class="table table-responsive table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($data as $v)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $v->ProductID }}</td>
                    <td>{{ $v->Nama }}</td>
                    <td>{{ $v->Harga }}</td>
                    <td>{{ $v->Stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script src="{{ asset('/admin/plugins/jQuery/jquery-3.2.0.min.js') }}"></script>
<script src="{{ asset('/js/pages/transaction/print.js') }}"></script>
@endpush
