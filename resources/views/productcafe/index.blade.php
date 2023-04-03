@extends('shared.master')
@section('title', 'Master Data Product Cafe')
@section('classcontent', 'content')
@section('PageHeader', 'Master Data Product Cafe')
@push('styles')
  <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/datatables.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.css') }}" />
  <style type="text/css">
      .uppercase {
          text-transform: uppercase;
      }
  </style>
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
            <div class="box-body">
                <table id="product" class="table table-hover table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prod as $v)
                            <tr>
                                <td>{{ $v->ProductID }}</td>
                                <td>{{ $v->Nama }}</td>
                                <td>{{ $v->Harga }}</td>
                                <td>{{ $v->Stock }}</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-xs showMe" data-href="{{ url('/productcafe/edit/'.$v->id) }}" style="width:100%">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-inline text-right">
            <div class="form-group">
                <a href="{{ url('/productcafe/printlist') }}" class="btn btn-warning" target="_blank">Print</a>
            </div>
            <div class="form-group">
                <button type="button" name="btnAdd" class="btn btn-primary showMe" data-href="{{ url('/productcafe/add') }}">Add New</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('/admin/plugins/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/maskmoney/jquery.maskMoney.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('/js/pages/productcafe/modalcafe.js') }}"></script>
  <script src="{{ asset('/js/pages/productcafe/product.js') }}"></script>
@endpush
