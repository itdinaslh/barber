@extends('shared.master')
@section('title', 'Master Data Metode Pembayaran')
@section('classcontent', 'content')
@section('PageHeader', 'Master Data Metode Pembayaran')
@push('styles')
  <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/datatables.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
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
                  <table id="metode_pembayaran" class="table table-responsive table-bordered table-hover table-stripped">
                      <thead>
                          <tr>
                              <th>Metode Pembayaran</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                  </table>
              </div>
          </div>
      </div>
      <div class="col-xs-12">
          <div class="text-right">
              <button type="button" name="btnAdd" class="btn btn-primary showMe" data-href="{{ url('/metode_pembayaran/add') }}">Add New</button>
          </div>
      </div>
  </div>

  @push('scripts')
    <script src="{{ asset('/admin/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/autonumeric/autoNumeric.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script src="{{ asset('/js/modalForm.js') }}"></script>
    <script src="{{ asset('/js/pages/metode_pembayaran/index.js') }}"></script>
  @endpush
@endsection
