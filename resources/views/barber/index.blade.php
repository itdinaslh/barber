@extends('shared.master')
@section('title', 'Master Data Barberman')
@section('classcontent', 'content')
@section('PageHeader', 'Master Data Barberman')
@push('styles')
  <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/datatables.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/plugins/select2/select2.min.css') }}" />
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
                <table id="barberman" class="table table-bordered table-hover table-responsive dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>No Identitas</th>
                            <th>Telp</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bbs as $v)
                            <tr>
                                <td id="bb-{{ $v->id }}" data-kode="{{ $v->Kode }}">{{ $v->Kode }}</td>
                                <td id="nama-{{ $v->id }}" data-nama="{{ $v->Nama }}">{{ $v->Nama }}</td>
                                <td>{{ $v->IdNum }}</td>
                                <td>{{ $v->Phone }}</td>
                                @if($v->Level == 'S')
                                  <td>Senior</td>
                                @elseif($v->Level == 'M')
                                  <td>Madya</td>
                                @elseif($v->Level == 'J')
                                  <td>Junior</td>
                                @endif
                                <td>
                                  <button type="button" name="btnEdit" class="btn btn-xs btn-success showMe" style="width:100%" data-href="/barberman/edit-{{ $v->id }}">Edit</button>
                                  <button type="button" name="btnService" class="btn btn-xs btn-warning sDetail" data-value="{{ $v->id }}" style="width:100%;margin-top:3px;">Service</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-12" style="margin-bottom:15px;">
        <div class="text-right">
            <button type="button" name="btnAdd" class="btn btn-primary showMe" data-href="{{ url('/barberman/add') }}">Add New</button>
        </div>
    </div>
    <div id="detailDiv" class="col-xs-12" style="display:none;">
        <div class="box">
            <div class="box-header">
              <h3 id="DetailTitle" class="box-title">List Service "J002 - Victor"</h3>
            </div>
            <div class="box-body">
                <form id="formService" class="form-inline" action="/barberman/addservice" method="post">
                    {{ csrf_field() }}
                    <input id="inputbid" type="hidden" name="BbID" value="0" />
                    <div class="form-group">
                        <label for="ServiceID">Service</label>
                        <select class="form-control select2" name="ServiceID" id="sid" required>
                            @foreach($serv as $s)
                                <option value="{{ $s->id }}">{{ $s->ServiceName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Harga">Harga</label>
                        <input type="text" id="pid" class="form-control" name="Harga" autocomplete="off" required />
                    </div>
                    <div class="form-group">
                        <label for="Fee">Fee</label>
                        <input type="text" id="fid" class="form-control" name="Fee" autocomplete="off" required />
                    </div>
                    <button type="submit" class="btn btn-success" id="btnSave" style="width:100px;">Add</button>
                </form>

                <div id="bbserv" style="margin-top:15px">
                    <table class="table table-hover table-bordered table-responsive table-stripped" id="service">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Service</th>
                                <th>Harga</th>
                                <th>Fee</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
  <script src="{{ asset('/admin/plugins/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('/admin/plugins/select2/select2.full.min.js') }}"></script>
  <script src="{{ asset('/js/pages/barberman/index.js') }}"></script>
  <script src="{{ asset('/js/modalForm.js') }}"></script>
@endpush
