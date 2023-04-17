<?php

namespace App\Http\Controllers;
use App\Models\Bbman;
use App\Models\Bbserv;
use App\Models\Service;
use DataTables;
use Illuminate\Http\Request;
use DB;

class BarberController extends Controller
{
    // Barber based action
    public function index() {
       $data = Bbman::all();
       $service = Service::select('id', 'ServiceName')->get();
       return view('barber.index', ['bbs' => $data, 'serv' => $service]);
    }

    public function addNew() {
        return view('barber.add');
    }

    public function addPost(Request $bb) {
        $bbm = new Bbman;

        $bbm->Nama = $bb->Nama;
        $bbm->IdNum = $bb->IdNum;
        $bbm->Phone = $bb->Phone;
        $bbm->Level = $bb->Level;

        $bbm->save();

        $data = Bbman::select('id')
                     ->orderBy('id', 'desc')
                     ->first();

        $row = Bbman::findOrFail($data->id);

        $id = (string)$data->id;

        if(strlen($id) == 1) {
            $kode = $bb->Level.'00'.$id;
        } elseif (strlen($id) == 2) {
            $kode = $bb->Level.'0'.$id;
        } else {
            $kode = $bb->Level.$id;
        }

        $row->Kode = $kode;

        $row->save();

        return ['success' => true];
    }

    public function edit($id) {
        $bb = Bbman::findOrFail($id);

        return view('barber.edit', ['bb' => $bb]);
    }

    public function editPost(Request $req) {
        $data = Bbman::findOrFail($req->id);

        $id = (string)$data->id;

        if(strlen($id) == 1) {
            $kode = $req->Level.'00'.$id;
        } elseif (strlen($id) == 2) {
            $kode = $req->Level.'0'.$id;
        } else {
            $kode = $req->Level.$id;
        }

        $data->Kode = $kode;
        $data->Nama = $req->Nama;
        $data->IdNum = $req->IdNum;
        $data->Phone = $req->Phone;
        $data->Level = $req->Level;

        $data->save();

        return ['success' => true];
    }

    //barber service
    public function servicePost(Request $req) {
        $service = Service::findOrFail($req->ServiceID);
        $data = new Bbserv;

        $data->BbID = $req->BbID;
        $data->ServiceID = $req->ServiceID;
        $data->Harga = $service->Harga;
        $data->Fee = $req->Fee;

        $data->save();

        return ['success' => true];
    }

    public function serviceAjax($id) {
        $data = DB::table('bbserv as a')
                  ->join('bbman as b', 'a.BbID', '=', 'b.id')
                  ->join('service as s', 'a.ServiceID', '=', 's.id')
                  ->select('a.id as id', 'a.BbID', 'b.Kode', 'b.Nama', 's.ServiceName', 'a.Harga', 'a.Fee')
                  ->where('b.id', $id)->get();

        foreach($data as $v) {
            $v->Harga = number_format($v->Harga, 0, ',', '.');
            $v->Fee = number_format($v->Fee, 0, ',', '.');
        }

        return DataTables::of($data)
                         ->addColumn('action', function($data) {
                              return '<button type="button" class="btn btn-xs btn-success showMe" data-href="/barberman/editservice/'.$data->id.'" style="width:100%;">Edit</button> <br />
                                      <button
                                        type="button" class="btn btn-xs btn-danger btnDel" data-val="'.$data->id.'"
                                        data-bbid="'.$data->BbID.'" style="width:100%;margin-top:3px;">Delete
                                      </button>';
                         })
                         ->make(true);
    }

    public function EditServicePost(Request $req) {
        $data = Bbserv::findOrFail($req->bbservid);

        $data->ServiceID = $req->ServiceID;
        $data->Harga = $req->Harga;
        $data->Fee = $req->Fee;

        $data->save();

        return ['success' => true];
    }

    public function deleteService($id) {
        $data = Bbserv::findOrFail($id);

        $data->delete();

        return ['success' => true];
    }

    public function EditService($id) {
        $serv = Service::All();

        $bbserv = Bbserv::findOrFail($id);

        return view('barber.editserv', ['serv' => $serv, 'bbserv' => $bbserv]);
    }
}
