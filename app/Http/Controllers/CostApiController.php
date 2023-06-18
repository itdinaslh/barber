<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\CostOp;
use App\Models\Operational;
use DateTime;
use Carbon\Carbon;
use Auth;

class CostApiController extends Controller
{
    public function monthly() {
        $curDate = new DateTime(date('Y-m-d'));
        $firstDate = $curDate->format('Y-m-01');
        $lastDate = $curDate->format('Y-m-t');

        $data = DB::table('cost_op as co')
            ->join('operational as o', 'co.opID', 'o.id')
            ->select('co.id', 'o.NamaOp', 'co.Total', 'co.created_by',
                DB::raw('DATE_FORMAT(co.Tanggal, "%d-%m-%Y") as Tanggal'),
                DB::raw("DATE_FORMAT(co.created_at, '%H:%i:%s') as Time")
            )
            ->whereBetween('co.Tanggal', [$firstDate, $lastDate])
            ->orderBy('co.id', 'desc')
            ->get();

        if (!is_null($data)) {
            foreach($data as $row) {
                $row->Total = number_format($row->Total, 0, ',', '.');
            }
        }

        return response()->json($data, 200);
    }

    public function getOpList() {
        $data = DB::table('operational')
            ->select('id', 'NamaOp')
            ->get();

        return response()->json($data, 200);
    }

    public function storeCost(Request $v) {
        $data = new CostOp;

        $date = DateTime::createFromFormat('d-m-Y', $v->Tanggal);

        $data->Tanggal = $date->format('Y-m-d');
        $data->opID = $v->opID;
        $data->Price = (int)$v->Price;
        $data->Qty = (int)$v->Qty;
        $data->total = (int)$v->Price * (int)$v->Qty;
        $data->ket = $v->ket;
        $data->created_by = Auth::user()->name;

        $data->save();

        return response()->json(['ok'], 200);
    }
}
