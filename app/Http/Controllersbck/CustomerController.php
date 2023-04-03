<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transaction;
use DateTime;
use DataTables;
use DB;
use Carbon\Carbon;

class CustomerController extends Controller
{
    //
    public function index() {
        return view('customer.index');
    }

    public function CustomerAjax() {
        $data = Customer::select(['id', 'Nama', 'Phone', 'IdNum', 'BirthDate', 'Occupation', 'City', 'Email']);

        // $data->BirthDate = date_format($data->BirthDate, 'd-m-Y');

        return DataTables::of($data)
                         ->addColumn('action', function($data) {
                              return '<button type="button" class="btn btn-success btn-xs showMe" style="width:100%" data-href="/customer/edit-'.$data->id.'">
                                      Edit</button>';
                         })
                         ->make(true);
    }

    public function addNew() {
        return view('customer.add');
    }

    public function GetOrder() {
        return view('customer.order');
    }

    public function addPost(Request $v) {
        $cust = new Customer;
        $cust->Nama = $v->Nama;
        $cust->Phone = $v->Phone;
        $cust->IdNum = $v->IdNum;
        if (isset($v->BirthDate)) {
            $date = DateTime::createFromFormat('d/m/Y', $v->BirthDate);
            $cust->BirthDate = $date;
        }
        $cust->Occupation = $v->Occupation;
        $cust->City = $v->City;
        $cust->Email = $v->Email;
        $cust->CreatedBy = $v->uid;
        $cust->ModifiedBy = $v->uid;

        $cust->save();

        return ['success' => true];
    }

    public function edit($id){
        $data = Customer::findOrFail($id);

        if(!is_null($data->BirthDate)) {
            $date = DateTime::createFromFormat('Y-m-d', $data->BirthDate);
            $date = date_format($date, 'd/m/Y');
        } else {
            $date = null;
        }

        return view('customer.edit', ['cust' => $data, 'birthdate' => $date]);
    }

    public function EditPost(Request $cust) {
        $v = Customer::findOrFail($cust->sid);

        $v->Nama = $cust->Nama;
        $v->Phone = $cust->Phone;
        $v->IdNum = $cust->IdNum;
        if (isset($cust->BirthDate)) {
            $date = DateTime::createFromFormat('d/m/Y', $cust->BirthDate);
            $v->BirthDate = $date;
        }
        $v->Occupation = $cust->Occupation;
        $v->City = $cust->City;
        $v->Email = $cust->Email;
        $v->ModifiedBy = $cust->uid;

        $v->save();

        return ['success' => true];
    }

    public function GetVisit($id) {
        $data = DB::table('customer as c')
                  ->join('transactions as t', 'c.id', '=', 't.MemberID')
                  ->select('t.created_at as LastVisit')
                  ->where('t.MemberID', $id)
                  ->orderBy('t.id', 'desc')
                  ->take(1)
                  ->get();

        if(!$data->isEmpty()) {
            foreach($data as $v) {
                $v->LastVisit = date_format(new DateTime($v->LastVisit), 'd-M-Y');
            }

            return $data;
        } else {
            $visit = array([
                'LastVisit' => ''
            ]);
            return $visit;
        }

        return $data;

    }

    public function AddAndOrder(Request $req) {
        date_default_timezone_set('Asia/Jakarta');



        $data = new Customer;

        $data->Nama = trim($req->Nama);
        $data->IdNum = trim($req->IdNum);
        if (isset($req->BirthDate)) {
            $date = DateTime::createFromFormat('d/m/Y', $req->BirthDate);
            $data->BirthDate = $date;
        }
        $data->Phone = trim($req->Phone);
        $data->Occupation = trim($req->Occupation);
        $data->City = trim($req->City);
        $data->Email = trim($req->Email);
        $data->LastVisit = Carbon::now();
        $data->CreatedBy = $req->UserID;
        $data->ModifiedBy = $req->UserID;

        $data->save();

        $cust = DB::table('customer')
                  ->select('id')
                  ->where('Nama', trim($req->Nama))
                  ->orderBy('id', 'desc')
                  ->first();

        $c = Customer::findOrFail($cust->id);

        $trans = new Transaction;

        $trans->LocationID = 11;
        $trans->UserID = $req->UserID;
        $trans->TrxType = 0;
        $trans->MemberID = $c->id;
        $trans->Print = 0;
        $trans->Lock = 0;

        $trans->save();

        return ['success' => true];
    }
}
