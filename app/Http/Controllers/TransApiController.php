<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DB;

class TransApiController extends Controller
{
    public function today() {
        date_default_timezone_set('Asia/Jakarta');

        $now = date('Y-m-d');

        $awal = '2023-03-01 00:00:00';
        $akhir = '2023-03-30 23:59:59';

        $trans = DB::table('transactions as t')
            ->select(
                DB::raw('DATE(t.created_at) as Tgl'), 't.id as TrxID', 't.TotalPaid',
                DB::raw("DATE_FORMAT(t.created_at, '%H:%i:%s') as Time")
            )
            ->where('t.Lock', 1)
            ->whereBetween('t.created_at', [$awal, $akhir])
            ->get();

        if (!is_null($trans)) {
            foreach($trans as $row) {
                $row->TotalPaid = number_format($row->TotalPaid, 0, ',', '.');
            }
        }

        return response()->json($trans, 200);
    }
}
