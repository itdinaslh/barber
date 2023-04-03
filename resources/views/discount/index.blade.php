@extends('shared.master')
@section('title', 'Master Data Discounts')
@section('classcontent', 'content')
@section('PageHeader', 'Master Data Discounts')
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
                    <table id="discounts" class="table table-bordered table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Discount ID</th>
                                <th>Harga</th>
                                <th>Tgl Kadaluarsa</th>
                                <th>Valid</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="text-right">
                <button type="button" name="btnMultiple" class="btn btn-warning showMe"
                    data-href="{{ url('/discounts/multiple') }}">Add Multiple</button>
                <button type="button" name="btnAdd" class="btn btn-primary showMe"
                    data-href="{{ url('/discounts/add') }}">Add New</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/admin/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('/admin/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('/admin/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <script src="{{ asset('/admin/plugins/autonumeric/autoNumeric.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/js/pages/discount/modalDisc.js') }}"></script>
    <script src="{{ asset('/js/pages/discount/discount.js') }}"></script>
@endpush
