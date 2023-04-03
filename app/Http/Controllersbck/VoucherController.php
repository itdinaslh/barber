<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\Voucher;
use DateTime;
use Carbon\Carbon;
use DataTables;

class VoucherController extends Controller
{
    //
    public function index() {
        return view('voucher.index');
    }

    public function CheckID($id) {
        $data = DB::table('vouchers')
                  ->select('id', 'Price', 'ValidUntil', 'IsValid')
                  ->where('VoucherID', $id)
                  ->first();

        if(!is_null($data)) {
            $price = $data->Price;
            $now = Carbon::now();
            $expire = $data->ValidUntil;

            if($now > $expire) {
                return ['expired' => true];
            }

            if ($data->IsValid == 0) {
                return ['used' => true];
            }

            return ['success' => true, 'data' => $price];
        }
    }

    public function ajaxVouchers() {
        $data = DB::table('vouchers')
                  ->select('id', 'VoucherID', 'Price', 'ValidUntil', 'IsValid');

        return Datatables::of($data)
                         ->addColumn('action', function($data) {
                            return '<button type="button" class="btn btn-success btn-xs showMe" data-href="/vouchers/edit/'.$data->id.'" style="width:100%;">Edit</button>';
                         })
                         ->addColumn('fPrice', function($data) {
                            return number_format($data->Price, 0, ',', '.');
                         })
                         ->addColumn('fValidUntil', function($data) {
                            $date = DateTime::createFromFormat('Y-m-d', $data->ValidUntil);
                            return date_format($date, 'd-M-Y');
                         })
                         ->make(true);
    }

    public function GetNew() {
        return view('voucher.add');
    }

    public function EditGet($id) {
        date_default_timezone_set('Asia/Jakarta');

        $data = Voucher::findOrFail($id);

        $date = DateTime::createFromFormat('Y-m-d', $data->ValidUntil);

        $date = date_format($date, 'd/m/Y');

        return view('voucher.edit', ['disc' => $data, 'valid' => $date]);
    }

    public function AddPost(Request $req) {
        date_default_timezone_set('Asia/Jakarta');

        $check = Voucher::where('VoucherID', $req->VoucherID)
                         ->select('id')
                         ->first();

        if (!is_null($check)) {
            return ['used' => true];
        }

        $data = new Voucher;

        $data->VoucherID = $req->VoucherID;
        $data->Price = $req->rPrice;
        $date = DateTime::createFromFormat('d/m/Y', $req->ValidUntil);
        $data->ValidUntil = $date;
        $data->IsValid = $req->IsValid;

        $data->save();

        return ['success' => true];
    }

    public function EditPost(Request $req) {
        date_default_timezone_set('Asia/Jakarta');

        if($req->rid != $req->VoucherID) {
            $check = Voucher::where('VoucherID', $req->VoucherID)
                             ->select('id', 'VoucherID')
                             ->first();

             if (!is_null($check)) {
                 return ['used' => true];
             }
        }

        $data = Voucher::findOrFail($req->did);

        $data->VoucherID = $req->VoucherID;
        $data->Price = $req->rPrice;
        $date = DateTime::createFromFormat('d/m/Y', $req->ValidUntil);
        $data->ValidUntil = $date;

        $data->save();

        return ['success' => true];
    }
}
