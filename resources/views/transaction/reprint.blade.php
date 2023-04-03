@extends('shared.master')
@section('title', 'Reprint Struk')
@section('classcontent', 'content')
@section('PageHeader', 'Reprint Struk')
@push('styles')
  <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/datatables.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.css') }}" />
@endpush

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="DataStruk" class="table table-responsive table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No. Trx</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
  <script src="{{ asset('/admin/plugins/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('/js/pages/transaction/reprint.js') }}"></script>
@endpush
