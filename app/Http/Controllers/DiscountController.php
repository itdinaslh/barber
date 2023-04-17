<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\Discount;
use DateTime;
use Carbon\Carbon;
use DataTables;

class DiscountController extends Controller
{
    //
    public function index() {
        return view('discount.index');
    }

    public function CheckID($id) {
        $data = DB::table('discounts')
                  ->select('id', 'Price', 'ValidUntil', 'IsValid')
                  ->where('DiscountID', $id)
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

    public function ajaxDiscounts() {
        $data = DB::table('discounts')
                  ->select('id', 'DiscountID', 'Price', 'ValidUntil', 'IsValid', 'Note', \DB::raw('(CASE
                  WHEN IsPrice = "0" THEN "%"
                  ELSE "Rp. "
                  END) AS IsPrice'));

        return Datatables::of($data)
                         ->addColumn('action', function($data) {
                            return '<button type="button" class="btn btn-success btn-xs showMe" data-href="/discounts/edit/'.$data->id.'" style="width:100%;">Edit</button>';
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
        $last = Discount::select('DiscountID')
                        ->orderBy('id', 'desc')
                        ->first();

        $next = $last->DiscountID + 1;

        return view('discount.add', ['next' => $next]);
    }

    public function EditGet($id) {
        date_default_timezone_set('Asia/Jakarta');

        $data = Discount::findOrFail($id);

        $date = DateTime::createFromFormat('Y-m-d', $data->ValidUntil);

        $date = date_format($date, 'd/m/Y');

        return view('discount.edit', ['disc' => $data, 'valid' => $date]);
    }

    public function AddPost(Request $req) {
        date_default_timezone_set('Asia/Jakarta');

        $check = Discount::where('DiscountID', $req->DiscountID)
                         ->select('id')
                         ->first();

        if (!is_null($check)) {
            return ['used' => true];
        }

        $data = new Discount;

        $data->DiscountID = $req->DiscountID;
        $data->Price = $req->rPrice;
        $date = $req->ValidUntil;
        $data->ValidUntil = $date;
        $data->IsValid = $req->IsValid;
        $data->Note = $req->Note;
        $data->IsPrice = $req->IsPrice;
        $data->save();

        return ['success' => true];
    }

    public function EditPost(Request $req) {
        date_default_timezone_set('Asia/Jakarta');

        if($req->rid != $req->DiscountID) {
            $check = Discount::where('DiscountID', $req->DiscountID)
                             ->select('id', 'DiscountID')
                             ->first();

             if (!is_null($check)) {
                 return ['used' => true];
             }
        }

        $data = Discount::findOrFail($req->did);

        $data->DiscountID = $req->DiscountID;
        $data->Price = $req->rPrice;
        $date = DateTime::createFromFormat('d/m/Y', $req->ValidUntil);
        $data->ValidUntil = $date;
        $data->Note = $req->Note;

        $data->save();

        return ['success' => true];
    }

    public function AddBulk() {
        $last = Discount::select('DiscountID')
                       ->orderBy('id', 'desc')
                       ->first();

        $next = $last->DiscountID + 1;

        return view('discount.addbulk', ['next' => $next]);
    }

    public function AddBulkPost(Request $req) {
        date_default_timezone_set('Asia/Jakarta');
        $id = $req->DiscountID;
        $seq = $req->DiscountVol;
        $total = $id + $seq;

        for($x=$id; $x < $total; $x++) {
            $cek = DB::table('discounts')
                     ->select('id')
                     ->where('DiscountID', $x)
                     ->first();

            if(!is_null($cek)) {
                return ['invalid' => true];
            }
        }

        for($i=$id; $i < $total; $i++) {
            $data = new Discount;

            $data->DiscountID = $i;
            $date = DateTime::createFromFormat('d/m/Y', $req->ValidUntil);
            $data->ValidUntil = $date;
            $data->Price = $req->rPrice;
            $data->IsValid = $req->IsValid;
            $data->Note = trim($req->Note);

            $data->save();
        }

        return ['success' => true];
    }
}
