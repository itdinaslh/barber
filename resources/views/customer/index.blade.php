@extends('shared.master')
@section('title', 'Master Data Customer')
@section('classcontent', 'content')
@section('PageHeader', 'Master Data Customer')
@push('styles')
  <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/datatables.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/datepicker/datepicker3.css') }}" />
  <style type="text/css">
      .uppercase {
          text-transform: uppercase;
      }
      #customerdetail td {
        padding: 7px;
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
                <table id="customer" class="table table-bordered table-hover table-responsive dataTable">
                    <thead>
                        <tr>
                            <th>Member ID</th>
                            <th>Nama</th>
                            <th>Telp</th>
                            <th>No Identitas</th>
                            <th>Tgl Lahir</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-12" style="margin-bottom:15px;">
        <div class="text-right">
            <button type="button" name="btnAdd" class="btn btn-primary showMe" data-href="{{ url('/customer/add') }}">Add New</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
  <script src="{{ asset('/admin/plugins/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/input-mask/jquery.inputmask.js') }}"></script>
  <script src="{{ asset('/admin/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
  <script src="{{ asset('/admin/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
  <script src="{{ asset('/js/modalForm.js') }}"></script>
  <script src="{{ asset('/js/pages/transaction/support.js') }}"></script>
@endpush
