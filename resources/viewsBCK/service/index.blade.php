@extends('shared.master')
@section('title', 'Master Data Service')
@section('classcontent', 'content')
@section('PageHeader', 'Master Data Service')
@push('styles')
  <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/datatables.min.css') }}" />
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
            <div class="box-body">
                <table id="service" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Service</th>
                            <th>Harga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($serv as $v)
                            <tr>
                               <td>{{ $v->id }}</td>
                               <td>{{ $v->ServiceName }}</td>
                               <td>{{ $v->Harga }}</td>
                               <td><button type="button" name="btnEdit" class="btn btn-xs btn-success showMe" style="width:100%" data-href="/service/edit-{{ $v->id }}">Edit</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="text-right">
            <button type="button" name="btnAdd" class="btn btn-primary showMe" data-href="{{ url('/service/add') }}">Add New</button>
        </div>
    </div>
</div>

@push('scripts')
  <script src="{{ asset('/admin/plugins/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/maskmoney/jquery.maskMoney.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script>
    $('#service').dataTable({
        lengthMenu:[5,10,15,20]
    });
  </script>
  <script src="{{ asset('/js/modalForm.js') }}"></script>
@endpush
@endsection
