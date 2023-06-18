<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DB;

class TransApiController extends Controller
{
    public function daily(Request $v) {
        date_default_timezone_set('Asia/Jakarta');

        $now = $v->Tanggal;

        $awal = $now.' 00:00:00';
        $akhir = $now.' 23:59:59';

        $trans = DB::table('transactions as t')
            ->select(
                DB::raw('DATE(t.created_at) as Tgl'), 't.id as TrxID', 't.TotalPaid',
                DB::raw("DATE_FORMAT(t.created_at, '%H:%i:%s') as Time")
            )
            ->where('t.Lock', 1)
            ->whereBetween('t.created_at', [$awal, $akhir])
            ->orderBy('t.id', 'desc')
            ->get();

        if (!is_null($trans)) {
            foreach($trans as $row) {
                $row->TotalPaid = number_format($row->TotalPaid, 0, ',', '.');
            }
        }

        return response()->json($trans, 200);
    }

    public function sumTodayCard() {
        date_default_timezone_set('Asia/Jakarta');

        $now = date('Y-m-d');

        $awal = $now.' 00:00:00';
        $akhir = $now.' 23:59:59';

        $curDate = new DateTime(date('Y-m-d'));
        $firstDate = $curDate->format('Y-m-01');
        $lastDate = $curDate->format('Y-m-t');

        $trans = DB::table('transactions as t')
            ->select(
                DB::raw('COALESCE(SUM(t.TotalPaid), 0) as TotalSum'),
                DB::raw('COUNT(t.id) as TotalCount')
            )
            ->where('t.Lock', 1)
            ->whereBetween('t.created_at', [$awal, $akhir])
            ->first();

        $transMonthly = DB::table('transactions as t')
            ->select(
                DB::raw('COALESCE(SUM(t.TotalPaid), 0) as TotalSum')
            )
            ->where('t.Lock', 1)
            ->whereBetween('t.created_at', [$firstDate, $lastDate])
            ->first();

        $cost = DB::table('cost_op as co')
            ->select(
                DB::raw('COALESCE(SUM(co.Total), 0) as TotalCost')
            )
            ->whereBetween('co.Tanggal', [$firstDate, $lastDate])
            ->first();

        $costVal = number_format($cost->TotalCost, 0, ',', '.');

        $arr = array("TotalSum" => 0, "TotalCount" => 0, "TotalCost" => 0);

        $arr['TotalSum'] = $trans->TotalSum != 0 ? number_format($trans->TotalSum, 0, ',', '.') : '0';
        $arr['MonthlyIncome'] = $transMonthly->TotalSum != 0 ? number_format($transMonthly->TotalSum, 0, ',', '.') : '0';
        $arr['TotalCount'] = $trans->TotalCount != 0 ? number_format($trans->TotalCount, 0, ',', '.') : '0';
        $arr['TotalCost'] = $costVal;

        return response()->json($arr, 200);
    }
}
