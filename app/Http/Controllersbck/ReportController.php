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


class ReportController extends Controller
{
    public function index() {

        return view('report.index');
    }
    public function ExcelBulanan($tAwal, $tAkhir) {
        $Awal = Carbon::create($tAwal)->startOfDay() ->toDateTimeString();
        $Akhir =  Carbon::create($tAkhir)->endOfDay()->toDateTimeString();
        return Excel::download(new LaporanExport($Awal, $Akhir), 'laporan bulanan ' . $tAwal. ' sd ' . $tAkhir. '.xlsx');
    }
}
