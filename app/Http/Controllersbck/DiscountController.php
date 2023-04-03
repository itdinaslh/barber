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
                  ->select('id', 'DiscountID', 'Price', 'ValidUntil', 'IsValid');

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
        return view('discount.add');
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
        $date = DateTime::createFromFormat('d/m/Y', $req->ValidUntil);
        $data->ValidUntil = $date;
        $data->IsValid = $req->IsValid;

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

        $data->save();

        return ['success' => true];
    }
}
