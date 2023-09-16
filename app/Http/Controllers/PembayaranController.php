<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Carbon\Carbon;
use DataTables;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    //
    public function index() {
        return view('metode_pembayaran.index');
    }

    public function ajaxData() {
        $data = DB::table('payments')
                  ->select('id', 'Name');

        return Datatables::of($data)
                         ->addColumn('action', function($data) {
                              return '<button type="button" class="btn btn-xs btn-success showMe" data-href="/metode_pembayaran/edit/'.$data->id.'">Edit</button>
                              <button
                                        type="button" class="btn btn-xs btn-danger btnDel" data-val="'.$data->id.'"
                                        style="margin-top:3px;">Delete
                                      </button>';
                         })
                         ->make(true);
    }

    public function AddNew() {
        return view('metode_pembayaran.add');
    }

    public function AddPost(Request $req) {
        $data = new Pembayaran;
        $data->Name = $req->Name;
        $data->save();

        return ['success' => true];
    }

    public function EditGet($id) {
        $data = Pembayaran::findOrFail($id);

        return view('metode_pembayaran.edit', ['data' => $data]);
    }

    public function EditPost(Request $req) {
        $data = Pembayaran::findOrFail($req->PembayaranID);

        if(is_null($data)) {
            return ['notfound' => true];
        }

        $data->Name = $req->Name;
        $data->save();

        return ['success' => true];
    }

    public function deleteService($id) {
        $data = Pembayaran::findOrFail($id);

        $data->delete();

        return ['success' => true];
    }

}
