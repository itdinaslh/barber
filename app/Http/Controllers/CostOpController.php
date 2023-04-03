<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\CostOp;
use App\Models\Operational;
use DateTime;
use Carbon\Carbon;
use DataTables;

class CostOpController extends Controller
{
    //
    public function index() {


        return view('cost_op.index');
    }

    public function ajaxcost_ops() {
        $data = DB::table('cost_op as c')
                    ->join('operational as o', 'c.opID', '=', 'o.id')
                    ->select('c.id','c.Tanggal', 'o.NamaOp', 'c.Price','c.Qty', 'c.Total', 'c.Ket');

        return Datatables::of($data)
                         ->addColumn('action', function($data) {
                            return '<button type="button" class="btn btn-success btn-xs showMe" data-href="/cost_op/edit/'.$data->id.'" style="width:100%;">Edit</button>';
                         })
                         ->addColumn('fPrice', function($data) {
                            return number_format($data->Price, 0, ',', '.');
                         })
                         ->addColumn('fTotal', function($data) {
                            return number_format($data->Total, 0, ',', '.');
                         })
                         ->make(true);
    }

    public function GetNew() {
        $data = Operational::all();
        return view('cost_op.add', ['data' => $data]);
    }

    public function EditGet($id) {
        $disc = DB::table('cost_op as c')
        ->join('operational as o', 'c.opID', '=', 'o.id')
        ->select('c.id','c.Tanggal', 'o.NamaOp', 'c.Price','c.Qty', 'c.Total', 'c.Ket')
        ->where('c.id','=', $id)
        ->first();
        $data = Operational::all();
        return view('cost_op.edit', ['disc' => $disc, 'data' => $data]);
    }

    public function AddPost(Request $req) {
        $total = (int)$req->rPrice * (int)$req->Qty;
        $data = new CostOp;

        $data->Tanggal = $req->tanggal;
        $data->opID = $req->opID;
        $data->Price = $req->rPrice;
        $data->Qty = $req->Qty;
        $data->Total = $total;
        $data->Ket = $req->Ket;
        $data->created_by = $req->uid;
        $data->save();

        return ['success' => true];
    }

    public function EditPost(Request $req) {
        $total = (int)$req->rPrice * (int)$req->Qty;
        $data = CostOp::findOrFail($req->did);

        $data->Tanggal = $req->tanggal;
        $data->opID = $req->opID;
        $data->Price = $req->rPrice;
        $data->Qty = $req->Qty;
        $data->Total = $total;
        $data->Ket = $req->Ket;
        $data->created_by = $req->uid;
        $data->save();

        return ['success' => true];
    }
}
