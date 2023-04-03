<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Service;

class ServiceController extends Controller
{
    //
    public function index() {
        $data = Service::select(['id', 'ServiceName', 'Harga'])->get();
        foreach($data as $v) {
            $v->Harga = number_format($v->Harga, 0, ',', '.');
        }
        return view('service.index', ['serv' => $data]);
    }

    public function ajaxService() {
        $data = Service::select(['id', 'ServiceName', 'Harga']);

        return Datatables::of($data)
                          ->addColumn('action', function($data) {
                              return '<button type="button" name="btnEdit" class="btn btn-xs btn-success showMe" style="width:100%" data-href="/service/edit-'.$data->id.'">Edit</button>';
                            })
        ->make(true);
    }

    public function addNew() {
        return view('service.add');
    }

    public function addPost(Request $req) {
        $serv = new Service;

        $serv->ServiceName = $req->ServiceName;
        $serv->Harga = $req->Harga;

        $serv->save();

        return ['success' => true];
    }

    public function edit($id) {
        $data = Service::findOrFail($id);

        return view('service.edit', ['serv' => $data]);
    }

    public function editPost(Request $req) {
        $serv = Service::findOrFail($req->sid);

        $serv->ServiceName = $req->ServiceName;
        $serv->Harga = $req->Harga;

        $serv->save();

        return ['success' => true];
    }
}
