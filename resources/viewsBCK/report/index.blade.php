@extends('shared.master')

@section('title', 'Report')
@section('classcontent', 'content')

@section('PageHeader', 'Report')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datepicker/datepicker3.css') }}" />
@endpush

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="panel" id="panel-tgl">
                        <div class="panel-hdr bg-primary-700 bg-success-gradient" role="heading">
                            <h2>Pilih Tanggal</h2>
                        </div>
                        <div class="panel-container show">
                            <div class="panel-content">
                                <form id="frmNgawur" action="/thisIsNgawooorrr" method="post">
                                    <div class="form-row">
                                        <div class="form-group col-md-3 col-xs-12">
                                            <label for="">Tanggal Awal</label>
                                            <div class="input-group flex-nowrap">
                                                <input type="text" name="TglAwal" id="TglAwal"
                                                    class="form-control datepicker" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 col-xs-12">
                                            <label for="">Tanggal Akhir</label>
                                            <div class="input-group flex-nowrap">
                                                <input type="text" name="TglAkhir" id="TglAkhir"
                                                    class="form-control datepicker" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-xs-12">
                                            {{-- <button type="submit" id="btnSubmit" class="btn btn-info" style="margin-top:25px;height:36px;" value="Cek Data">Cek Data</button> --}}
                                            <button type="button" id="btnExcel" class="btn btn-success"
                                                style="margin-top:25px;height:36px;">Download Excel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('/admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            })
        });

        $('#frmNgawur').submit(function(e) {
            e.preventDefault();

            $('input:text[required]').parent().show();

            var tglAwal = $('#TglAwal').val();
            var tglAkhir = $('#TglAkhir').val();

            LoadReport(tglAwal, tglAkhir);
        });

        $('#btnExcel').click(function() {
            var tAwal = $('#TglAwal').val();
            var tAkhir = $('#TglAkhir').val();

            if (tAwal == '') {
                alert('Isi Tanggal Awal!');
            } else if (tAkhir == '') {
                alert('Isi Tanggal Akhir!')
            } else {
                var url = "/report/excel/" + tAwal + "/" + tAkhir;

                var win = window.open("", "_blank");

                win.location.href = url;

                win.focus;
            }
        });

        // function LoadReport(tglAwal, tglAkhir) {
        //     $('#rptBulanan').DataTable().destroy();
        //     $('#rptBulanan').DataTable({
        //         serverSide: true,
        //         processing: true,
        //         responsive: true,
        //         lengthMenu: [5, 10, 20],
        //         pagingType: "simple_numbers",
        //         ajax: {
        //             url: '/clients/jasa/angkutan/laporan/bulanan/' + tglAwal + '/' + tglAkhir,
        //             method: 'GET'
        //         },
        //         columns: [{
        //                 data: 'rownum',
        //                 name: 'rownum'
        //             },
        //             {
        //                 data: 'NamaLokasi',
        //                 name: 'lokasiangkutan.NamaLokasi'
        //             },
        //             {
        //                 data: 'NoPolisi',
        //                 name: 'kendaraan.NoPolisi'
        //             },
        //             {
        //                 data: 'TglAngkut',
        //                 name: 'reportangkutan.TglAngkut'
        //             },
        //             {
        //                 data: 'JnsSampah',
        //                 name: 'reportangkutan.JnsSampah'
        //             },
        //             {
        //                 data: 'LokasiTujuan',
        //                 name: 'reportangkutan.LokasiTujuan'
        //             },
        //             {
        //                 data: 'JmlSampah',
        //                 name: 'reportangkutan.JmlSampah',
        //                 searchable: false,
        //                 orderable: false
        //             },
        //             {
        //                 data: 'JmlReduksi',
        //                 name: 'reportangkutan.JmlReduksi',
        //                 searchable: false,
        //                 orderable: false
        //             },
        //             {
        //                 data: 'JmlResidu',
        //                 name: 'reportangkutan.JmlResidu',
        //                 searchable: false,
        //                 orderable: false
        //             }
        //         ],
        //         order: [
        //             [0, "desc"]
        //         ]
        //     });
        // }
    </script>
@endpush
