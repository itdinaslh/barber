<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\Bbman;
use App\Models\Bbserv;
use App\Models\Customer;
use App\Models\Transbbdetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Transbbproduct;
use DataTables;
use DB;
use DateTime;
use Carbon\Carbon;
use App\Models\Discount;
use App\Models\Voucher;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Shared_Date;

class ReportController extends Controller
{
    //
    public function LapBBManCheck(Request $req) {
        $fDate = $req->TglAwal;
        $lDate = $req->TglAkhir;
        $bbman = $req->BbID;
    }

    public function LapBBMan() {
        $barber = DB::table('bbman')
                    ->select('id', 'Kode', 'Nama')
                    ->get();

        return view('cashier.reports.lapbbman', ['data' => $barber]);
    }

    public function CashierLapBbmanIndex() {
        date_default_timezone_set('Asia/Jakarta');
        $date = Carbon::now();
        $date = date_format($date, 'd-m-Y');

        $barber = DB::table('bbman')
                    ->select('id', 'Kode', 'Nama')
                    ->get();

        return view('cashier.reports.bbmandaily', ['date' => $date, 'data' => $barber]);
    }

    // public function CashierPrintLapDaily($tanggal) {
    //     $awal = $tanggal.' 00:00:00';
    //     $akhir = $tanggal.' 23:59:59';
    //
    //     $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
    //     $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);
    //     $recap = DB::table('transbbdetails as t')
    //                 ->join('transactions as a', 't.TrxID', '=', 'a.id')
    //                 ->select('t.ServiceName', DB::raw('sum(Qty) as Total'))
    //                 ->where('t.BbID', $id)
    //                 ->whereBetween('a.created_at', [$first, $end])
    //                 ->groupBy('t.ServiceName')
    //                 ->get();
    //
    //     return view('cashier.reports.cashierprintdaily');
    // }

    public function PrintLapBBMan($tglawal, $tglakhir, $id) {
        date_default_timezone_set('Asia/Jakarta');

        $now = Carbon::now();

        $hour = date_format($now, 'H:i:s');

        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $date1 = date_format($first, 'd-M-Y');
        $date2 = date_format($end, 'd-M-Y');

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        if ($id == 0) {
            $recap = DB::table('transbbdetails as t')
                        ->select('t.ServiceName', DB::raw('sum(Qty) as Total'))
                        ->whereBetween('t.created_at', [$first, $end])
                        ->groupBy('t.ServiceName')
                        ->get();

            $barber = 'All';
        } else {
            $barber = Bbman::findOrFail($id);

            $recap = DB::table('transbbdetails as t')
                        ->select('t.ServiceName', DB::raw('sum(Qty) as Total'))
                        ->where('t.BbID', $id)
                        ->whereBetween('t.created_at', [$first, $end])
                        ->groupBy('t.ServiceName')
                        ->get();
        }

        return view('cashier.reports.lapbbmanprint', ['first' => $date1, 'end' => $date2, 'barber' => $barber, 'recap' => $recap, 'hour' => $hour, 'id' => $id]);
    }

    public function LapBBManager($tglawal, $tglakhir, $id) {
        date_default_timezone_set('Asia/Jakarta');

        $now = Carbon::now();

        $hour = date_format($now, 'H:i:s');

        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $date1 = date_format($first, 'd-M-Y');
        $date2 = date_format($end, 'd-M-Y');

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        $barber = Bbman::findOrFail($id);

        $recap = DB::table('transbbdetails as t')
                    ->select('t.ServiceName', DB::raw('sum(Qty) as Total'), 't.Fee', DB::raw('(sum(Qty) * t.Fee) as TotalFee'))
                    ->where('t.BbID', $id)
                    ->whereBetween('t.created_at', [$first, $end])
                    ->groupBy('t.ServiceName', 't.Fee')
                    ->get();

        $total = 0;

        foreach($recap as $v) {
            $total += $v->TotalFee;
            $v->Fee = number_format($v->Fee, 0, ',', '.');
            $v->TotalFee = number_format($v->TotalFee, 0, ',', '.');
        }

        $total = number_format($total, 0, ',', '.');

        return view('reports.lapbbmanager', ['first' => $date1, 'end' => $date2,
                    'barber' => $barber, 'total' => $total, 'recap' => $recap, 'hour' => $hour, 'id' => $id]);
    }

    public function CashierPrintLapBBDaily($tglawal, $tglakhir, $id) {
        date_default_timezone_set('Asia/Jakarta');

        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $tanggal = Carbon::now();

        $tanggal = date_format($tanggal, 'd-M-Y H:i:s');

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $barber = Bbman::findOrFail($id);

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);
        $recap = DB::table('transbbdetails as t')
                    ->select('t.ServiceName', DB::raw('sum(Qty) as Total'))
                    ->where('t.BbID', $id)
                    ->whereBetween('t.created_at', [$first, $end])
                    ->groupBy('t.ServiceName')
                    ->get();

        return view('cashier.reports.bbmandailyprint', ['tanggal' => $tanggal, 'barber' => $barber, 'recap' => $recap]);
    }

    public function RecapIndex() {
        return view('cashier.reports.recapindex');
    }

    public function PrintRecap($tglawal, $tglakhir) {
        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $date1 = date_format($first, 'd-M-Y');
        $date2 = date_format($end, 'd-M-Y');

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        $recap = DB::table('transactions as t')
                    ->select(DB::raw('sum(TotalPaid) as Cash'), DB::raw('sum(VoucherVal) as Voucher'), DB::raw('sum(Discount) as Discount'), DB::raw('count(id) as TotalCus'))
                    ->whereBetween('t.created_at', [$first, $end])
                    ->where('t.Lock', '1')
                    ->first();

        $total = $recap->Cash + $recap->Voucher + $recap->Discount;

        $recap->Cash = number_format($recap->Cash, 0, ',', '.');
        $recap->Voucher = number_format($recap->Voucher, 0, ',', '.');
        $recap->Discount = number_format($recap->Discount, 0, ',', '.');

        $total = number_format($total, 0, ',', '.');
        $TotalCus =$recap->TotalCus;

        return view('cashier.reports.recapprint', ['recap' => $recap, 'first' => $date1, 'end' => $date2, 'total' => $total, 'TotalCus'=>$TotalCus]);
    }

    public function PrintLapTrans($tglawal, $tglakhir) {
        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        $data = DB::table('transactions as t')
                  ->join('payments as p', 't.PayMethod', '=', 'p.id')
                  ->join('customer as c', 't.MemberID', '=', 'c.id')
                  ->select('t.created_at as tgl', 't.id as TrxID', 't.TotalTrx', 't.DiscountID', 't.Discount',
                           't.VoucherID', 't.VoucherVal', 't.TotalPaid', 'p.Name as PayMethod')
                  ->whereBetween('t.created_at', [$first, $end])
                  ->get();

        $SumTrx = 0;
        $SumDiscount = 0;
        $SumVoucher = 0;
        $SumPaid = 0;

        foreach($data as $v) {
            $SumTrx += $v->TotalTrx;
            $SumDiscount += $v->Discount;
            $SumVoucher += $v->VoucherVal;
            $SumPaid += $v->TotalPaid;
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $v->tgl);
            $v->tgl = date_format($date, 'd/m/y');
            $v->TotalTrx = number_format($v->TotalTrx, 0, ',', '.');
            $v->Discount = number_format($v->Discount, 0, ',', '.');
            $v->VoucherVal = number_format($v->VoucherVal, 0, ',', '.');
            $v->TotalPaid = number_format($v->TotalPaid, 0, ',', '.');
        }

        $SumTrx = number_format($SumTrx, 0, ',', '.');
        $SumDiscount = number_format($SumDiscount, 0, ',', '.');
        $SumVoucher = number_format($SumVoucher, 0, ',', '.');
        $SumPaid = number_format($SumPaid, 0, ',', '.');

        return view('reports.printtrans', ['data' => $data, 'SumTrx' => $SumTrx, 'SumDiscount' => $SumDiscount, 'SumVoucher' => $SumVoucher, 'SumPaid' => $SumPaid]);
    }

    public function ajaxTransReport($tglawal, $tglakhir) {
        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        $data = DB::table('transactions as t')
                  ->join('payments as p', 't.PayMethod', '=', 'p.id')
                  ->join('customer as c', 't.MemberID', '=', 'c.id')
                  ->select('t.created_at as tgl', 't.id as TrxID', 't.TotalTrx', 't.DiscountID', 't.Discount',
                           't.VoucherID', 't.VoucherVal', 't.TotalPaid', 'p.Name as PayMethod')
                  ->whereBetween('t.created_at', [$first, $end]);

        return Datatables::of($data)
                         ->addColumn('fTgl', function($data) {
                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $data->tgl);
                            return date_format($date, 'd/m/y');
                         })
                         ->addColumn('fTotalTrx', function($data) {
                            return number_format($data->TotalTrx, 0, ',', '.');
                         })
                         ->addColumn('fDiscount', function($data) {
                            return number_format($data->Discount, 0, ',', '.');
                         })
                         ->addColumn('fVoucherVal', function($data) {
                            return number_format($data->VoucherVal, 0, ',', '.');
                         })
                         ->addColumn('fTotalPaid', function($data) {
                            return number_format($data->TotalPaid, 0, ',', '.');
                         })
                         ->make(true);
    }

    public function ajaxCostReport($tglawal, $tglakhir) {

        $data = DB::table('cost_op as c')
        ->join('operational as o', 'c.opID', '=', 'o.id')
        ->select('c.Tanggal', 'o.NamaOp', 'c.Price','c.Qty', 'c.Total', 'c.Ket')
                  ->whereBetween('c.Tanggal', [$tglawal, $tglakhir]);

        return Datatables::of($data)
                                ->addColumn('fPrice', function($data) {
                                    return number_format($data->Price, 0, ',', '.');
                                })
                                ->addColumn('fTotal', function($data) {
                                    return number_format($data->Total, 0, ',', '.');
                                })
                                ->make(true);
    }

    function GetSumCost($tglawal, $tglakhir) {
        $data = DB::table('cost_op')
                  ->select(DB::raw('sum(Total) as SumTrx'))
                  ->whereBetween('Tanggal', [$tglawal, $tglakhir])
                  ->first();



        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $in = DB::table('transactions as t')
                  ->select(DB::raw('sum(TotalTrx) as SumTrx'), DB::raw('sum(Discount) as SumDiscount'),
                           DB::raw('sum(VoucherVal) as SumVoucher'), DB::raw('sum(TotalPaid) as SumTotal'))
                  ->whereBetween('t.created_at', [$awal, $akhir])
                  ->first();


        $result =$in->SumTotal -  $data->SumTrx;
        $result = number_format($result, 0, ',', '.');
        $in->SumTotal = number_format($in->SumTotal, 0, ',', '.');
        $data->SumTrx = number_format($data->SumTrx, 0, ',', '.');

        return ['SumTrx' => $data->SumTrx, 'SumTotal' => $in->SumTotal, 'result' => $result];
    }

    public function DownloadExcelBbs($tglawal, $tglakhir) {
        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);
        return Excel::download(new LaporanExport($first, $end), 'laporan bulanan ' . $tglawal. ' sd ' . $tglakhir. '.xlsx');
    }
    // public function DownloadExcelBbs($tglawal, $tglakhir) {
    //     $first = DateTime::createFromFormat('d-m-Y', $tglawal);
    //     $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

    //     $awal = $tglawal.' 00:00:00';
    //     $akhir = $tglakhir.' 23:59:59';

    //     $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
    //     $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

    //     $data = DB::table('transactions as t')
    //               ->join('payments as p', 't.PayMethod', '=', 'p.id')
    //               ->join('customer as c', 't.MemberID', '=', 'c.id')
    //               ->select('t.created_at as Tanggal', 't.id as TrxID', 't.TotalTrx', 't.DiscountID', 't.Discount as Discount(Rp)',
    //                        't.VoucherID', 't.VoucherVal as Voucher(Rp)',  'p.Name as Payment', 't.TotalPaid')
    //               ->whereBetween('t.created_at', [$first, $end])
    //               ->get();


    //     foreach($data as $v) {
    //         $date = DateTime::createFromFormat('Y-m-d H:i:s', $v->Tanggal);
    //         $v->Tanggal = date_format($date, 'Y-m-d');
    //     }

    //     $data = json_decode( json_encode($data), true);

    //     return Excel::create('NmBarbershopReport', function($excel) use ($data) {
    //         $excel->sheet('DATA', function($sheet) use ($data) {
    //             $sheet->setColumnFormat([
    //               'A' => 'dd-mm-yy',
    //               'C' => '#,##0',
    //               'E' => '#,##0',
    //               'G' => '#,##0',
    //               'I' => '#,##0'
    //             ]);
    //             foreach($data AS &$row) {
    //                 // convert content to Excel date stamp
    //                 $row['Tanggal'] = PHPExcel_Shared_Date::PHPToExcel(strtotime($row['Tanggal']));
    //             }
    //             $sheet->fromArray($data);
    //         });
    //     })->download('xlsx');
    // }

    public function DownloadPdfBbs($tglawal, $tglakhir) {
      $first = DateTime::createFromFormat('d-m-Y', $tglawal);
      $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

      $awal = $tglawal.' 00:00:00';
      $akhir = $tglakhir.' 23:59:59';

      $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
      $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

      $data = DB::table('transactions as t')
                ->join('payments as p', 't.PayMethod', '=', 'p.id')
                ->join('customer as c', 't.MemberID', '=', 'c.id')
                ->select('t.created_at as Tanggal', 't.id as TrxID', 't.TotalTrx', 't.DiscountID', 't.Discount as Discount(Rp)',
                         't.VoucherID', 't.VoucherVal as Voucher(Rp)',  'p.Name as Payment', 't.TotalPaid')
                ->whereBetween('t.created_at', [$first, $end])
                ->get();


      foreach($data as $v) {
          $date = DateTime::createFromFormat('Y-m-d H:i:s', $v->Tanggal);
          $v->Tanggal = date_format($date, 'Y-m-d');
      }

      $data = json_decode( json_encode($data), true);

      return Excel::create('NmBarbershopReport', function($excel) use ($data) {
          $excel->sheet('DATA', function($sheet) use ($data) {
              $sheet->setColumnFormat([
                'A' => 'dd-mm-yy',
                'C' => '#,##0',
                'E' => '#,##0',
                'G' => '#,##0',
                'I' => '#,##0'
              ]);
              foreach($data AS &$row) {
                  // convert content to Excel date stamp
                  $row['Tanggal'] = PHPExcel_Shared_Date::PHPToExcel(strtotime($row['Tanggal']));
              }
              $sheet->fromArray($data);
          });
      })->download('pdf');
    }

    function GetSum($tglawal, $tglakhir) {
        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        $data = DB::table('transactions as t')
                  ->select(DB::raw('sum(TotalTrx) as SumTrx'), DB::raw('sum(Discount) as SumDiscount'),
                           DB::raw('sum(VoucherVal) as SumVoucher'), DB::raw('sum(TotalPaid) as SumTotal'))
                  ->whereBetween('t.created_at', [$first, $end])
                  ->first();

        $data->SumTrx = number_format($data->SumTrx, 0, ',', '.');
        $data->SumDiscount = number_format($data->SumDiscount, 0, ',', '.');
        $data->SumVoucher = number_format($data->SumVoucher, 0, ',', '.');
        $data->SumTotal = number_format($data->SumTotal, 0, ',', '.');

        return ['SumTrx' => $data->SumTrx, 'SumDiscount' => $data->SumDiscount, 'SumVoucher' => $data->SumVoucher, 'SumTotal' => $data->SumTotal];
    }



    public function AjaxPivotTrans($tglawal, $tglakhir) {
        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        $data = DB::table('transactions as t')
                  ->join('transbbdetails as a', 't.id', '=', 'a.TrxID')
                  ->join('bbman as b', 'a.BbID', '=', 'b.id')
                  ->select('a.created_at as Tanggal', 'b.Nama as Barberman', 'a.ServiceName as Service', 'a.Fee', 'a.Total as TpS')
                  ->whereBetween('a.created_at', [$first, $end])
                  ->get();

        foreach($data as $v) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $v->Tanggal);
            $v->Tanggal = date_format($date, 'd-M-Y');
        }

        return $data;
    }

    //Cafe reports
    public function CafeIndex() {
        return view('reports.cafe');
    }

    public function PrintLapCafe($tglawal, $tglakhir) {
        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        $data = DB::table('transcafe as t')
                  ->join('payments as p', 't.PaymentID', '=', 'p.id')
                  ->select('t.created_at as tgl', 't.id as TrxID', 't.Total', 't.Discount', DB::raw('(Total - Discount) as GT'),
                           'p.Name as PayMethod')
                  ->whereBetween('t.created_at', [$first, $end])
                  ->get();

        $SumTrx = 0;
        $SumDiscount = 0;
        $SumPaid = 0;

        foreach($data as $v) {
            $SumTrx += $v->Total;
            $SumDiscount += $v->Discount;
            $SumPaid += $v->GT;
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $v->tgl);
            $v->tgl = date_format($date, 'd/m/y');
            $v->Total = number_format($v->Total, 0, ',', '.');
            $v->Discount = number_format($v->Discount, 0, ',', '.');
            $v->GT = number_format($v->GT, 0, ',', '.');
        }

        $SumTrx = number_format($SumTrx, 0, ',', '.');
        $SumDiscount = number_format($SumDiscount, 0, ',', '.');
        $SumPaid = number_format($SumPaid, 0, ',', '.');

        return view('reports.printtranscafe', ['data' => $data, 'SumTrx' => $SumTrx, 'SumDiscount' => $SumDiscount, 'SumPaid' => $SumPaid]);
    }

    public function AjaxCafe($tglawal, $tglakhir) {
        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        $data = DB::table('transcafe as t')
                  ->join('payments as p', 't.PaymentID', '=', 'p.id')
                  ->select('t.id', 't.created_at as tanggal', 'p.Name as payment', 't.Total', 't.Discount', DB::raw('((Total) - (Discount)) as GrandTotal'))
                  ->whereBetween('t.created_at', [$first, $end]);

        return Datatables::of($data)
                         ->addColumn('fTgl', function($data) {
                             $date = DateTime::createFromFormat('Y-m-d H:i:s', $data->tanggal);
                             return date_format($date, 'd/m/y');
                         })
                         ->addColumn('fTotalTrx', function($data) {
                             return number_format($data->Total, 0, ',', '.');
                         })
                         ->addColumn('fDiscount', function($data) {
                             return number_format($data->Discount, 0, ',', '.');
                         })
                         ->addColumn('fGrand', function($data) {
                             return number_format($data->GrandTotal, 0, ',', '.');
                         })
                         ->make(true);
    }

    public function GetSumCafe($tglawal, $tglakhir) {
        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        $data = DB::table('transcafe')
                  ->select(DB::raw('sum(Total) as SumTrx'), DB::raw('sum(Discount) as SumDiscount'), DB::raw('(sum(Total) - sum(Discount)) as GrandTotal'))
                  ->whereBetween('created_at', [$first, $end])
                  ->first();

        $data->SumTrx = number_format($data->SumTrx, 0, ',', '.');
        $data->SumDiscount = number_format($data->SumDiscount, 0, ',', '.');
        $data->GrandTotal = number_format($data->GrandTotal, 0, ',', '.');

        return ['SumTrx' => $data->SumTrx, 'SumDiscount' => $data->SumDiscount, 'GrandTotal' => $data->GrandTotal];
    }

    public function CafePivotTrans($tglawal, $tglakhir) {
        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        $data = DB::table('transcafedetails as t')
                  ->join('transcafe as tc', 't.TrxID', '=', 'tc.id')
                  ->join('payments as p', 'tc.PaymentID', '=', 'p.id')
                  ->select('t.created_at as Tanggal', 't.Nama as Produk', 'p.Name as Payment', 't.Qty', DB::raw('(t.Harga * t.Qty) as Total'))
                  ->whereBetween('t.created_at', [$first, $end])
                  ->get();

        foreach($data as $v) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $v->Tanggal);
            $v->Tanggal = date_format($date, 'd-M-Y');
        }

        return $data;
    }

    public function DownloadExcelCafe($tglawal, $tglakhir) {
        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        $data = DB::table('transcafe as t')
                  ->join('payments as p', 't.PaymentID', '=', 'p.id')
                  ->select('t.created_at as Tanggal', 't.id as TrxID', 'p.Name as payment', 't.Total as SubTotal', 't.Discount', DB::raw('(Total - Discount) as Total'))
                  ->whereBetween('t.created_at', [$first, $end])
                  ->get();


        foreach($data as $v) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $v->Tanggal);
            $v->Tanggal = date_format($date, 'Y-m-d');
        }

        $data = json_decode( json_encode($data), true);

        return Excel::create('NmCafeReport', function($excel) use ($data) {
            $excel->sheet('DATA', function($sheet) use ($data) {
                $sheet->setColumnFormat([
                  'A' => 'dd-mm-yy',
                  'D' => '#,##0',
                  'E' => '#,##0',
                  'F' => '#,##0'
                ]);
                foreach($data AS &$row) {
                    // convert content to Excel date stamp
                    $row['Tanggal'] = PHPExcel_Shared_Date::PHPToExcel(strtotime($row['Tanggal']));
                }
                $sheet->fromArray($data);
            });
        })->download('xlsx');
    }

    public function DownloadPdfCafe($tglawal, $tglakhir) {
        $first = DateTime::createFromFormat('d-m-Y', $tglawal);
        $end = DateTime::createFromFormat('d-m-Y', $tglakhir);

        $awal = $tglawal.' 00:00:00';
        $akhir = $tglakhir.' 23:59:59';

        $first = DateTime::createFromFormat('d-m-Y H:i:s', $awal);
        $end = DateTime::createFromFormat('d-m-Y H:i:s', $akhir);

        $data = DB::table('transcafe as t')
                  ->join('payments as p', 't.PaymentID', '=', 'p.id')
                  ->select('t.created_at as Tanggal', 't.id as TrxID', 'p.Name as payment', 't.Total')
                  ->whereBetween('t.created_at', [$first, $end])
                  ->get();


        foreach($data as $v) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $v->Tanggal);
            $v->Tanggal = date_format($date, 'Y-m-d');
        }

        $data = json_decode( json_encode($data), true);

        return Excel::create('NmCafeReport', function($excel) use ($data) {
            $excel->sheet('DATA', function($sheet) use ($data) {
                $sheet->setColumnFormat([
                  'A' => 'dd-mm-yy',
                  'D' => '#,##0'
                ]);
                foreach($data AS &$row) {
                    // convert content to Excel date stamp
                    $row['Tanggal'] = PHPExcel_Shared_Date::PHPToExcel(strtotime($row['Tanggal']));
                }
                $sheet->fromArray($data);
            });
        })->download('pdf');
    }
}
