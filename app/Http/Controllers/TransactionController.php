<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Service;
use App\Models\Bbman;
use App\Models\Bbserv;
use App\Models\Customer;
use App\Models\Transbbdetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Transbbproduct;
use Illuminate\Http\Request;
use DataTables;
use DB;
use DateTime;
use Carbon\Carbon;
use App\Models\Discount;
use App\Models\Voucher;

class TransactionController extends Controller
{
    //
    // public function testdate() {
    //     date_default_timezone_set('Asia/Jakarta');
    //     // $time = date_default_timezone_get();
    //     $data = Carbon::now();
    //     return $data;
    // }

    public function GetCustomerAjax($id) {
        $data = DB::table('customer as c')
                  ->leftJoin('transactions as t', 'c.id', '=', 't.MemberID')
                  ->select('c.id', DB::raw($id.' as userid'), 'c.Nama', 'c.Phone',
                            DB::raw("date_format(c.LastVisit, '%d-%b-%Y %T') as LastVisit"), DB::raw('count(t.id) as TotalVisit'))
                  ->groupBy('c.id', 'c.Nama', 'c.Phone', 'c.LastVisit');

        return DataTables::of($data)
                         ->addColumn('action', function($data) {
                              return '<form id="Form-'.$data->id.'" data-id="'.$data->id.'" class="formAddTrans" action="/transaction/new" method="post">
                                        '.csrf_field().'
                                        <input type="hidden" name="UserID" value="'.$data->userid.'" />
                                        <input type="hidden" name="member" value="'.$data->id.'" />
                                        <button
                                          type="submit" class="btn btn-xs btn-info btnOrder"
                                          style="width:100%;margin-top:3px;">Order
                                        </button>
                                      </form>';
                         })
                         ->make(true);
    }

    public function TransNewFromTable(Request $req, $id) {
        date_default_timezone_set('Asia/Jakarta');
        $conid = $id;

        $data = new Transaction;
        $data->LocationID = 11;
        $data->UserID = $req->UserID;
        $data->TrxType = 0;
        $data->MemberID = $req->member;
        $data->Print = 0;
        $data->Lock = 0;
        $data->created_at = Carbon::now();
        $data->updated_at = Carbon::now();
        $data->save();
        return ['success' => true];

    }

    public function NewTransaction(Request $req) {
        date_default_timezone_set('Asia/Jakarta');

        $tgl = Carbon::now();

        $data = new Transaction;

        $data->LocationID = 11;
        $data->UserID = $req->UserID;
        $data->TrxType = 0;
        $data->MemberID = $req->member;
        $data->Print = 0;
        $data->Lock = 0;
        $data->created_at = $tgl;
        $data->updated_at = $tgl;

        $data->save();

        $cust = Customer::findOrFail($req->member);

        $cust->LastVisit = $tgl;

        $cust->save();

        return ['success' => true];
    }

    public function index() {
        $service = Service::select('id', 'ServiceName')->get();
        $barb = Bbman::select('id', 'Nama')->get();
        $product = Product::select('id', 'ProductName')->get();
        return view('transaction.index', ['serv' => $service, 'barber' => $barb, 'product' => $product]);
    }

    public function CashierIndex() {
        $service = Service::select('id', 'ServiceName')->get();
        $barb = Bbman::select('id', 'Nama')->get();
        $product = Product::select('id', 'ProductName')->get();

        $data = DB::table('transactions as t')
                  ->join('customer as c', 't.MemberID', '=', 'c.id')
                  ->select('t.id', 't.MemberID', 'c.Nama', 't.created_at')
                  ->where('t.Lock', '=', 0)
                  ->orderBy('t.id', 'desc')
                  ->get();
        return view('transaction.cashier', ['data' => $data, 'serv' => $service, 'barber' => $barb, 'product' => $product]);
    }

    public function ajaxTrx() {
        $data = DB::table('transactions as t')
                  ->join('users as u', 't.UserID', '=', 'u.id')
                  ->join('customer as c', 't.MemberID', '=', 'c.id')
                  ->select('t.id', 'u.username', 'c.Nama', 't.Print', 't.Lock', 't.created_at');

        return DataTables::of($data)
                         ->addColumn('action', function($data) {
                              if($data->Lock == 1) {
                                return '<a href="/transaction/printpreview-'.$data->id.'" class="btn btn-warning" target="_blank"
                                        style="width:100%;">Print Struk</a>';
                              } else {
                                return '<button type="button" class="btn btn-success ngehek"
                                        data-trx="'.$data->id.'" data-name="'.$data->Nama.'" style="width:100%;">Detail Trx</button>';
                              }
                         })
                         ->make(true);
    }

    public function addBbDetail(Request $req) {
        $today = Carbon::now()->format('Y-m-d');
        $bbserv = DB::table('bbserv as b')
                    ->join('service as s', 'b.ServiceID', '=', 's.id')
                    ->select('b.id', 's.Harga', 'b.Fee', 's.ServiceName')
                    ->where('ServiceID', $req->ServiceID)
                    ->where('BbID', $req->BbID)
                    ->first();
        $d = DB::table('discounts')
                ->select('id', 'Price', 'ValidUntil', 'IsValid','IsPrice')
                ->where('IsValid', 1)
                ->where('ValidUntil', '>=', $today)
                ->first();

        if(isset($d)) {
            if($d->IsPrice == 1 ){
                $total = (($bbserv->Harga - $d->Price) * $req->Qty);
                $disc = $d->Price;
                $totald = ($d->Price * $req->Qty);
            } else {
                $disc = $d->Price * $bbserv->Harga / 100;
                $totald = ($d->Price * $req->Qty * $bbserv->Harga / 100);
                $total = ($bbserv->Harga * $req->Qty) -$totald;
            }
        } else {
            $total =  ($bbserv->Harga * $req->Qty);
            $totald = null;
            $disc = null;
        }


        $data = new Transbbdetail;

        $data->TrxID = $req->TrxID;
        $data->BbServID = $bbserv->id;
        $data->ServiceName = $bbserv->ServiceName;
        $data->Price = $bbserv->Harga;
        $data->BbID = $req->BbID;
        $data->Qty = $req->Qty;
        $data->Diskon = $disc;
        $data->TotalPrice = ($bbserv->Harga * $req->Qty);
        $data->TotalDiskon = $totald;
        $data->Total = $total;
        $data->Fee = $bbserv->Fee;

        $data->save();

        return ['success' => true];
    }

    public function addBbProduct(Request $req) {
        $prod = Product::select('id', 'Harga', 'Komisi', 'Stock')
                       ->where('id', $req->ProductID)
                       ->first();

        if($req->Qty > $prod->Stock) {
            return ['limit' => true];
        }

        $data = new Transbbproduct;

        $data->TrxID = $req->TrxProduct;
        $data->ProductID = $req->ProductID;
        $data->BbID = $req->BbID;
        $data->Price = $prod->Harga;
        $data->Qty = $req->Qty;
        $data->Total = ($prod->Harga * $req->Qty);
        $data->Fee = $prod->Komisi;

        $trans = Product::findOrFail($prod->id);
        $trans->Stock -= $req->Qty;

        $data->save();
        $trans->save();

        return ['success' => true];
    }

    public function ajaxTransProduct($id) {
        $prod = DB::table('transbbproducts as a')
                  ->join('transactions as b', 'a.TrxID', '=', 'b.id')
                  ->join('product as c', 'a.ProductID', '=', 'c.id')
                  ->join('bbman as d', 'a.BbID', '=', 'd.id')
                  ->select('a.id', 'a.TrxID', 'c.ProductName as ServName', 'd.Nama as BbName', 'a.Price', 'a.Qty', DB::raw('a.Price * a.Qty as Total'))
                  ->where('a.TrxID', $id)
                  ->get();

        foreach($prod as $v) {
            $v->Price = number_format($v->Price, 0, ',', '.');
            $v->Total = number_format($v->Total, 0, ',', '.');
        }

        return DataTables::of($prod)
                         ->addColumn('action', function($prod) {
                              return '<button
                                        type="button" class="btn btn-xs btn-danger btnDelProduct"
                                        data-id="'.$prod->id.'" data-trx="'.$prod->TrxID.'" style="width:100%;margin-top:3px;">Cancel
                                      </button>';
                         })
                         ->make(true);
    }

    public function ajaxTransbbdetail($id) {
        $data = DB::table('transbbdetails as a')
                  ->join('transactions as b', 'a.TrxID', '=', 'b.id')
                  ->join('bbserv as c', 'a.BbServID', '=', 'c.id')
                  ->join('service as s', 'c.ServiceID', '=', 's.id')
                  ->join('bbman as d', 'a.BbID', '=', 'd.id')
                  ->select('a.id', 'a.TrxID', 's.ServiceName as ServName', 'd.Nama as BbName', 'a.Price', 'a.Qty', DB::raw('a.Price * a.Qty as Total'))
                  ->where('a.TrxID', $id)
                  ->get();

        foreach($data as $v) {
            $v->Price = number_format($v->Price, 0, ',', '.');
            $v->Total = number_format($v->Total, 0, ',', '.');
        }

        return DataTables::of($data)
                         ->addColumn('action', function($data) {
                              return '<button
                                        type="button" class="btn btn-xs btn-danger btnDelDetail"
                                        data-id="'.$data->id.'" data-trx="'.$data->TrxID.'" style="width:100%;margin-top:3px;">Cancel
                                      </button>';
                         })
                         ->make(true);
    }

    public function ajaxdetails($id) {

        $prod = DB::table('transbbproducts as a')
                  ->join('transactions as b', 'a.TrxID', '=', 'b.id')
                  ->join('product as c', 'a.ProductID', '=', 'c.id')
                  ->join('bbman as d', 'a.BbID', '=', 'd.id')
                  ->select('a.id', 'a.TrxID',DB::raw('0 as Type'), 'c.ProductName as ServName', 'd.Nama as BbName', 'a.Price', 'a.Qty', DB::raw('a.Price * a.Qty as Total'))
                  ->where('a.TrxID', $id);

        $data = DB::table('transbbdetails as a')
                  ->join('transactions as b', 'a.TrxID', '=', 'b.id')
                  ->join('bbman as d', 'a.BbID', '=', 'd.id')
                  ->select('a.id', 'a.TrxID',DB::raw('1 as Type'), 'a.ServiceName as ServName', 'd.Nama as BbName', 'a.Price', 'a.Qty', DB::raw('a.Price * a.Qty as Total'))
                  ->where('a.TrxID', $id)
                  ->union($prod);
                //   ->get();

        // foreach($data as $v) {
        //     $v->Price = number_format($v->Price, 0, ',', '.');
        //     $v->Total = number_format($v->Total, 0, ',', '.');
        // }

        return DataTables::of($data)
                         ->addColumn('action', function($data) {
                              return '<button
                                        type="button" class="btn btn-xs btn-danger btnDelDetail"
                                        data-id="'.$data->id.'" data-type="'.$data->Type.'" data-trx="'.$data->TrxID.'" style="width:100%;margin-top:3px;">Cancel
                                      </button>';
                         })
                         ->make(true);
    }

    public function getTotalTrx($id) {
        $data = DB::table('transbbdetails')
                  ->where('TrxID', $id)
                  ->select(DB::raw('sum(Price * Qty) as Total'))
                  ->first();

        $prod = DB::table('transbbproducts')
                  ->where('TrxID', $id)
                  ->select(DB::raw('sum(Price * Qty) as Total'))
                  ->first();

        $total = $data->Total + $prod->Total;

        $total = number_format($total, 0, ',','.');


        return $total;
    }

    public function DeleteDetails($id) {
        $data = Transbbdetail::findOrFail($id);

        $data->delete();

        return ['success' =>true];
    }

    public function DeleteProducts($id) {
        $data = Transbbproduct::findOrFail($id);

        $prod = Product::findOrFail($data->ProductID);
        $prod->Stock += $data->Qty;
        $prod->save();

        $data->delete();

        return ['success' => true];
    }

    public function GetCheckout($id) {
        $payment = Payment::all();
        $trans = DB::table('transactions as t')
                   ->join('customer as c', 't.MemberID', '=', 'c.id')
                   ->select('t.id', 'c.Nama')
                   ->where('t.id', $id)
                   ->first();

        $data = DB::table('transactions as t')
                  ->join('customer as c', 't.MemberID', '=', 'c.id')
                  ->Join('transbbdetails as t1', 't.id', '=', 't1.TrxID')
                  ->where('t.id', $id)
                  ->groupBy('t1.TrxID')
                  ->select(['t.id', 'c.Nama', DB::raw('sum(t1.Price * t1.Qty) as Total')])
                  ->first();

        $prod = DB::table('transactions as a')
                  ->join('transbbproducts as b', 'a.id', '=', 'b.TrxID')
                  ->join('product as c', 'b.ProductID', '=', 'c.id')
                  ->select(DB::raw('sum(b.Price * b.Qty) as Total'))
                  ->where('a.id', $id)
                  ->first();
        $diskon = DB::table('transactions as t')
                  ->join('customer as c', 't.MemberID', '=', 'c.id')
                  ->Join('transbbdetails as t1', 't.id', '=', 't1.TrxID')
                  ->where('t.id', $id)
                  ->groupBy('t1.TrxID','t.id', 'c.Nama')
                  ->select(['t.id', 'c.Nama', DB::raw('sum(t1.Diskon * t1.Qty) as Total')])
                  ->first();

        $TotalService = 0;

        if(isset($data->Total)) {
            $TotalService = $data->Total;
        }

        $Total = $TotalService + $prod->Total;

        $TotalString = number_format($Total, 0, ',', '.');

        if(isset($data->Total)) {
            $TotalService = $data->Total;
        }

        $DiskonAll = 0;

        if(isset($diskon->Total)) {
            $DiskonAll = $diskon->Total;
        }

        $diskonS = number_format($DiskonAll, 0, ',', '.');

        $TotalP = $Total - $DiskonAll;
        $TotalPstring = number_format($TotalP, 0, ',', '.');

        // return $Total;
        return view('transaction.checkout',
            ['trans' => $trans,
            'payment' => $payment,
            'TotalHid' => $Total,
            'TotalString' => $TotalString,
            'DiskonAll' => $DiskonAll,
            'diskonS' => $diskonS,
            'TotalP' => $TotalP,
            'TotalPstring' => $TotalPstring ]);
    }

    public function FinalizeCheckout(Request $req) {
        date_default_timezone_set('Asia/Jakarta');
        $today = Carbon::now()->format('Y-m-d');
        $now = Carbon::now();
        $pid = $req->PaymentID;

        $data = Transaction::findOrFail($req->trx);

        $data->ModifiedBy = $req->uid;
        $data->PayMethod = $pid;
        $data->TotalTrx = $req->totalhid;
        if ($pid == 1) {
            $payval = $req->rPayVal;
            $data->CardID = null;
        } else {
            $payval = $req->rPayVal;
            $data->CardID = $req->CardID;
        }
        $data->PayVal = $payval;
        $d = DB::table('discounts')
                ->select('DiscountID')
                ->where('IsValid', 1)
                ->where('ValidUntil', '>=', $today)
                ->first();

        if(isset($d)) {
            $data->DiscountID = $d->DiscountID;
        }
        $data->Discount = $req->rDiskon;
        $paid = $req->totalhid - $req->rDiskon;

        // if(!is_null($req->rDisc) || $req->rDisc != '') {
        //     $d = DB::table('discounts')
        //             ->select('id', 'Price', 'ValidUntil', 'IsValid')
        //             ->where('DiscountID', $req->DiscountID)
        //             ->first();

        //     if(isset($d)) {
        //         if ($d->IsValid == 0 || $now > $d->ValidUntil) {
        //             return ['discountinvalid' => true];
        //         } else {
        //             $disc = $d->Price;
        //             $data->DiscountID = $req->DiscountID;
        //             $data->Discount = $disc;

        //             $dupd = Discount::findOrFail($d->id);

        //             $dupd->IsValid = 0;

        //             $dupd->save();
        //         }
        //     } else {
        //         $disc = null;
        //     }

        //     $paid = $req->totalhid - $disc;
        // } else {
        //     $disc = null;
        //     $paid = $req->totalhid;
        // }

        if($req->VoucherID != ''){
            if(!is_null($req->rVoucher) || $req->rVoucher != '' ) {
                $v = DB::table('vouchers')
                       ->select('id', 'Price', 'ValidUntil', 'IsValid')
                       ->where('VoucherID', $req->VoucherID)
                       ->first();
                if (is_null($v)) {
                    return ['vouchersalah' => true];
                }else{
                    if(isset($v)) {
                        if ($v->IsValid == 0 || $now > $v->ValidUntil) {
                            return ['voucherinvalid' => true];
                        } else {
                            $voucher = $v->Price;
                            $data->VoucherID = $req->VoucherID;
                            $data->VoucherVal = $voucher;

                            $vupd = Voucher::findOrFail($v->id);

                            $vupd->IsValid = 0;

                            $vupd->save();
                        }
                    }

                    $paid -= $voucher;
                }
            }
        }


        $data->TotalPaid = $paid;
        $data->Lock = 1;
        $data->updated_at = Carbon::now();

        $data->save();

        return ['success' => true];

    }

    public function PrintPreview($id) {
        $data = Transaction::findOrFail($id);

        $data->Print = 1;

        $data->save();

        $data = DB::table('transactions as t')
                  ->join('users as u', 't.UserID', '=', 'u.id')
                  ->join('customer as c', 't.MemberID', '=', 'c.id')
                  ->join('payments as p', 't.PayMethod', '=', 'p.id')
                  ->where('t.id', $id)
                  ->select('t.id', 'u.name', 'c.Nama', 't.created_at', 't.MemberID', 't.TotalTrx', 't.Discount', 't.VoucherVal', 't.PayVal', 'p.Name as PayMethod',
                            't.TotalPaid', DB::raw('(t.TotalTrx - t.TotalPaid) as Total'))
                  ->first();

        $Change = $data->PayVal - $data->TotalPaid;
        $data->created_at = date_format(new DateTime($data->created_at), 'd-M-Y');
        $data->TotalTrx = number_format($data->TotalTrx, 0, ',', '.');
        $data->Discount = number_format($data->Discount, 0, ',', '.');
        $data->VoucherVal = number_format($data->VoucherVal, 0, ',', '.');
        $data->PayVal = number_format($data->PayVal, 0, ',', '.');
        $data->Total = number_format($data->Total, 0, ',', '.');
        $data->TotalPaid = number_format($data->TotalPaid, 0, ',', '.');
        $Change = number_format($Change, 0, ',', '.');

        $detail = DB::table('transactions as t')
                    ->join('transbbdetails as td', 't.id', '=', 'td.TrxID')
                    ->join('bbserv as b', 'td.BbServID', '=', 'b.id')
                    ->join('service as s', 'b.ServiceID', '=', 's.id')
                    ->join('bbman as bb', 'b.BbID', '=', 'bb.id')
                    ->select('s.ServiceName', 'bb.Kode', 'td.Qty', 'td.Price', DB::raw('(td.Price * td.Qty) as SubTotal'))
                    ->where('td.TrxID', $id)
                    ->get();

        $prod = DB::table('transactions as a')
                  ->join('transbbproducts as b', 'a.id', '=', 'b.TrxID')
                  ->join('product as c', 'b.ProductID', '=', 'c.id')
                  ->join('bbman as d', 'b.BbID', '=', 'd.id')
                  ->select('c.ProductName', 'd.Kode', 'b.Price', 'b.Qty', 'b.Total')
                  ->where('a.id', $id)
                  ->get();

        foreach($detail as $v) {
            $v->Price = number_format($v->Price, 0, ',', '.');
            $v->SubTotal = number_format($v->SubTotal, 0, ',', '.');
        }

        foreach($prod as $p) {
            $p->Price = number_format($p->Price, 0, ',', '.');
            $p->Total = number_format($p->Total, 0, ',', '.');
        }
        return view('transaction.printpreview', ['trans' => $data, 'details' => $detail, 'prod' => $prod, 'change' => $Change]);
    }

    public function PrintStruk($id) {
        $data = DB::table('transactions as t')
                  ->join('users as u', 't.UserID', '=', 'u.id')
                  ->join('customer as c', 't.MemberID', '=', 'c.id')
                  ->join('payments as p', 't.PayMethod', '=', 'p.id')
                  ->select('t.id', 'u.code as usercode', 't.created_at', 'c.Nama as CustName',
                          'c.id as CustID', 't.TotalTrx', 't.Discount', 't.VoucherVal', 'p.Name as PayMethod',
                          't.TotalPaid', 't.PayVal')
                  ->where('t.id', $id)
                  ->first();

        $change = $data->PayVal - $data->TotalPaid;
        $data->TotalTrx = number_format($data->TotalTrx, 0, ',', '.');
        $data->Discount = number_format($data->Discount, 0, ',', '.');
        $data->TotalPaid = number_format($data->TotalPaid, 0, ',', '.');
        $data->PayVal = number_format($data->PayVal, 0, ',', '.');
        $data->VoucherVal = number_format($data->VoucherVal, 0, ',', '.');
        $change = number_format($change, 0, ',', '.');
        $data->created_at = date_format(new DateTime($data->created_at), 'd-M-Y');

        $detail = DB::table('transactions as t')
                    ->join('transbbdetails as td', 't.id', '=', 'td.TrxID')
                    ->join('bbserv as bs', 'td.BbServID', 'bs.id')
                    ->join('service as s', 'bs.ServiceID', '=', 's.id')
                    ->join('bbman as b', 'td.BbID', 'b.id')
                    ->select('s.ServiceName', 'b.Kode', 'td.Qty', 'td.Price', DB::raw('(td.Price * td.Qty) as SubTotal'))
                    ->where('t.id', $id)
                    ->get();

        $prod = DB::table('transactions as a')
                  ->join('transbbproducts as b', 'a.id', '=', 'b.TrxID')
                  ->join('product as c', 'b.ProductID', '=', 'c.id')
                  ->join('bbman as d', 'b.BbID', '=', 'd.id')
                  ->select('c.ProductName', 'd.Kode', 'b.Price', 'b.Qty', 'b.Total')
                  ->where('a.id', $id)
                  ->get();

        $note = DB::table('notes')
                  ->where('Active', 1)
                  ->select('Content')
                  ->first();

        foreach($detail as $v) {
            $v->Price = number_format($v->Price, 0, ',', '.');
            $v->SubTotal = number_format($v->SubTotal, 0, ',', '.');
        }

        foreach($prod as $v) {
            $v->Price = number_format($v->Price, 0, ',', '.');
            $v->Total = number_format($v->Total, 0, ',', '.');
        }

        return view('transaction.print', ['trans' => $data, 'detail' => $detail, 'prod' => $prod, 'change' => $change, 'note' => $note]);

    }

    public function AjaxReprint() {
        $data = DB::table('transactions as t')
                  ->join('customer as c', 't.MemberID', '=', 'c.id')
                  ->select('t.id', 'c.Nama', DB::raw("date_format(t.created_at, '%d-%b-%Y %T') as date"))
                  ->where('t.Lock', 1)
                  ->orderBy('t.id', 'desc');

        return DataTables::of($data)
                         ->addColumn('action', function($data) {
                              return '<a href="/transaction/struk/'.$data->id.'" class="btn btn-warning" target="_blank"
                                      style="width:100%;">Print Struk</a>';
                         })
                         ->make(true);
    }

}
