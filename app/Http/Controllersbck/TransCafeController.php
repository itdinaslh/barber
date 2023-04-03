<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
// use Cart;
use App\Models\Productcafe;
use App\Models\Payment;
use App\Models\Transcafe;
use App\Models\Transcafedetail;
use Auth;

class TransCafeController extends Controller
{
    //
    public function index() {

        $data = Productcafe::All();
        // $total = Cart::total(0, ',', '.');
        return view('transcafe.index', ['prod' => $data]);

    }

    // public function AddSubTrans(Request $req) {
    //     $data = Productcafe::findOrFail($req->idprod);
    //     $cart = Cart::content();
    //     $qty = 0;

    //     foreach($cart as $v) {
    //         if ($v->id == $req->idprod) {
    //             $qty += $v->qty;
    //         }
    //     }

    //     if(($req->qty + $qty) > $data->Stock) {
    //         return ['limit' => true];
    //     }

    //     Cart::add([
    //         'id' => $data->id,
    //         'name' => $data->Nama,
    //         'qty' =>$req->qty,
    //         'price' => $data->Harga,
    //         'tax' => 0
    //     ]);
    //     return ['success' => true];
    // }

    // public function GetData() {
    //     $data = Cart::content();

    //     return DataTables::of($data)
    //                      ->addColumn('harga', function($data) {
    //                           return number_format($data->price, 0, ',', '.');
    //                      })
    //                      ->addColumn('subtotal', function($data) {
    //                           return number_format($data->qty * $data->price, 0, ',', '.');
    //                      })
    //                      ->addColumn('action', function($data) {
    //                           return '<button type="button" class="btn btn-danger btn-xs btnDelSub" style="width:100%;margin-top:5px;" data-row="'.$data->rowId.'">Delete Item</button>';
    //                      })
    //                     ->make(true);
    // }

    // public function GetTotalCart() {
    //     $data = Cart::total(0, ',', '.');

    //     return $data;
    // }

    // public function ClearCart() {
    //     Cart::destroy();

    //     return ['success' => true];
    // }

    // public function DelSub($id) {
    //     Cart::remove($id);

    //     return ['success' => true];
    // }

    // public function GetCheckout() {
    //     $data = Cart::content();

    //     $total = 0;

    //     foreach($data as $v) {
    //         $total += ($v->price * $v->qty);
    //     }

    //     $totalstring = Cart::total(0, ',', '.');

    //     $payment = Payment::All();

    //     return view('transcafe.checkout', ['TotalHid' => $total, 'payment' => $payment, 'TotalString' => $totalstring]);
    // }

    // public function CheckOut(Request $req) {
    //     date_default_timezone_set('Asia/Jakarta');

    //     $data = new Transcafe;

    //     $data->UserID = $req->uid;
    //     $data->PaymentID = $req->PaymentID;
    //     $data->Total = $req->totalhid;
    //     $data->PayVal = $req->rPayVal;
    //     $data->CardID = $req->CardID;

    //     $data->save();

    //     $cart = Cart::content();

    //     $trans = TransCafe::select('id')
    //                       ->where('UserID', $req->uid)
    //                       ->orderBy('id', 'desc')
    //                       ->first();

    //     foreach($cart as $v) {
    //         $prod = Productcafe::findOrFail($v->id);

    //         $prod->Stock -= $v->qty;

    //         $n = new Transcafedetail;

    //         $n->TrxID = $trans->id;
    //         $n->ProductID = $v->id;
    //         $n->Nama = $v->name;
    //         $n->Harga = $v->price;
    //         $n->Qty = $v->qty;

    //         $prod->save();

    //         $n->save();

    //         session(['strcafe' => $trans->id]);
    //     }

    //     Cart::destroy();

    //     return ['success' => true];

    // }

    public function PrintStruk() {
        $trans = DB::table('transcafe as t')
                   ->join('users as u', 'u.id', '=', 't.UserID')
                   ->join('payments as p', 'p.id', '=', 't.PaymentID')
                   ->select('t.id', 'u.name as username', 'u.code as usercode', 'p.Name as PayMethod', 't.created_at', 't.PayVal', 't.Total')
                    ->where('UserID', Auth::user()->id)
                    ->orderBy('id', 'desc')
                    ->first();

        $data = DB::table('transcafe as a')
                  ->join('transcafedetails as b', 'a.id', '=', 'b.TrxID')
                  ->select('b.Nama', 'b.Qty', 'b.Harga', DB::raw('(b.Harga * b.Qty) as Subtotal'))
                  ->where('a.id', $trans->id)
                  ->get();

        foreach($data as $v) {
            $v->Harga = number_format($v->Harga, 0, ',', '.');
            $v->Subtotal = number_format($v->Subtotal, 0, ',', '.');
        }

        $change = $trans->PayVal - $trans->Total;

        $trans->Total = number_format($trans->Total, 0, ',', '.');
        $trans->PayVal = number_format($trans->PayVal, 0, ',', '.');
        $change = number_format($change, 0, ',', '.');
        return view('transcafe.print', ['trans' => $trans, 'data' => $data, 'change' => $change]);
    }

}
