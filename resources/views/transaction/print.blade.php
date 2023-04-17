@extends('shared.print2')
@section('title', 'Print Struk')
@section('classcontent', 'invoice')
@push('styles')
    <style>
        @page {
            margin: 0;
        }

        * {
            transition: none !important
        }

        body {
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            width: 95mm;
            height: 140mm;
            font-size: 11px;
            padding-left: 5mm;
        }

        .head {
            font-weight: normal;
            text-align: left;
        }

        .myCenter {
            clear: both;
            text-align: center;
        }

        /*#detail tr td { font-weight: normal;}*/
        .separator {
            padding-top: 10px;
        }

        #foot {
            position: fixed;
            width: 95mm;
            bottom: 50mm;
            font-size: 10px;
            text-align: center;
        }

        #note {
            text-align: center;
        }

        .logo {
            width: 25px;
            height: 25px;
            float: left;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-xs-12 myCenter" style="margin-top:4mm;">
            <div>
                {{-- <img src="{{ asset('/img/logo-small.png') }}" class="img img-responsive logo" alt="" /> --}}
                <span style="font-size:35px;font-weight:bold;text-align:center ; text-decoration :underline ">My Brother
                    Haircare</span>
            </div>
        </div>
    </div>
    <div class="row invoice-info">
        <div class="col-xs-12">
            <div style="padding-bottom:1mm;text-align:center;font-size:12pt;border-bottom:1px solid black;font-weight:bold">
                it's more than just a hair cut <br />
                Jl. Kejayaan No.280, Abadijaya, Kec. Sukmajaya, Kota Depok, Jawa Barat 16417<br />
                {{-- fb : nm.barbershop17 / instagram : @nm.barbershop <br />
          Tlp / Wa : 0821 3369 5417 --}}
            </div>
            <div style="margin-top:0;border-bottom:1px solid black;padding-bottom:1mm;">
                <table style="font-size:20px;">
                    <tr>
                        <td>No. Trx</td>
                        <td style="padding-left:5px;padding-right:10px;">:</td>
                        <td>{{ $trans->id }} ({{ $trans->usercode }})</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td style="padding-left:5px;padding-right:10px;">:</td>
                        <td>{{ $trans->created_at }} </td>
                    </tr>
                    <tr>
                        <td>Customer</td>
                        <td style="padding-left:5px;padding-right:10px;">:</td>
                        <td>{{ $trans->CustName }} </td>
                    </tr>
                </table>
            </div>
            <div style="margin-top:0;">
                <table id="detail" style="width:100%; font-size:20px;">
                    <thead>
                        <tr>
                            <th class="head" style="width:7%">No</th>
                            <th class="head" style="width:49%">Service/Product</th>
                            <th class="head" style="width:14%">Qty</th>
                            <th class="head" style="text-align:right;width:30%;">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($detail as $v)
                            <tr>
                                <td>{{ $i++ }}.</td>
                                <td>{{ $v->ServiceName }}</td>
                                <td>{{ $v->Qty }}</td>
                                <td style="text-align:right;">{{ $v->SubTotal }}</td>
                            </tr>
                        @endforeach
                        @foreach ($prod as $v)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $v->ProductName }}</td>
                                <td>{{ $v->Qty }}</td>
                                <td style="text-align:right;">{{ $v->Total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="text-align:right;">- - - - - - - - - - - - - - - - - - - - - - - - -</div>
                <table style="width:100%;margin-top:1mm; font-size:20px;">
                    <tbody>
                        <tr>
                            <td style="width:5%"></td>
                            <td style="width:40%"></td>
                            <td style="width:10%"></td>
                            <td>Jumlah</td>
                            <td style="text-align:right">{{ $trans->TotalTrx }}</td>
                        </tr>
                        @if ($trans->Discount != 0)
                            <tr>
                                <td></td>
                                <td colspan="2" style="text-align:right;padding-right:2mm;">
                                </td>
                                <td>Discount</td>
                                <td style="text-align:right">{{ $trans->Discount }}</td>
                            </tr>
                        @endif
                        @if ($trans->VoucherVal != 0)
                            <tr>
                                <td></td>
                                <td colspan="2" style="text-align:right;padding-right:2mm;">({{ $trans->VoucherID }})
                                </td>
                                <td>Voucher</td>
                                <td style="text-align:right">{{ $trans->VoucherVal }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div style="text-align:right;">- - - - - - - - - - - - - - - - - - - - - - - - -</div>
                <table style="width:100%; font-size:20px;">
                    <tbody>
                        <tr>
                            <td style="width:5%"></td>
                            <td style="width:40%"></td>
                            <td style="width:10%"></td>
                            <td>Grand Total</td>
                            <td style="text-align:right">{{ $trans->TotalPaid }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>Dibayar</td>
                            <td style="text-align:right">{{ $trans->PayVal }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td style="font-decoration:italic;">{{ $trans->PayMethod }}</td>
                            <td style="text-align:right"></td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align:right;">- - - - - - - - - - - - - - - - - - - - - - - - -</div>
                <table style="width:100%; font-size:20px;">
                    <tbody>
                        <tr>
                            <td style="width:5%"></td>
                            <td style="width:40%"></td>
                            <td style="width:10%"></td>
                            <td>Kembali</td>
                            <td style="text-align:right">{{ $change }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <br>
            </div>
            {{-- <div id="foot" style="margin-bottom : 40 px font-weight:bold">
                {!! $note->Content !!}
                <div class="">
                    Terima kasih atas kunjungan anda
                </div>
            </div> --}}
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('/admin/plugins/jQuery/jquery-3.2.0.min.js') }}"></script>
    <script src="{{ asset('/js/pages/transaction/print.js') }}"></script>
@endpush
