<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\Operational;
use DateTime;
use Carbon\Carbon;
use DataTables;

class OperationalController extends Controller
{
    //
    public function index() {
        return view('operational.index');
    }

    public function ajaxOperationals() {
        $data = DB::table('operational')
                  ->select('id', 'NamaOp');

        return Datatables::of($data)
                         ->addColumn('action', function($data) {
                            return '<button type="button" class="btn btn-success btn-xs showMe" data-href="/operational/edit/'.$data->id.'" style="width:100%;">Edit</button>';
                         })
                         ->make(true);
    }

    public function GetNew() {
        return view('operational.add');
    }

    public function EditGet($id) {
        $data = Operational::findOrFail($id);

        return view('operational.edit', ['disc' => $data]);
    }

    public function AddPost(Request $req) {

        $data = new Operational;

        $data->NamaOp = $req->NamaOp;
        $data->save();

        return ['success' => true];
    }

    public function EditPost(Request $req) {

        $data = Operational::findOrFail($req->did);

        $data->NamaOp = $req->NamaOp;
        $data->save();

        return ['success' => true];
    }
}
