<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productcafe;

class ProductCafeController extends Controller
{
    //
    public function index() {
        $data = Productcafe::All();

        foreach($data as $v) {
            $v->Harga = number_format($v->Harga, 0, ',', '.');
        }

        return view('productcafe.index', ['prod' => $data]);
    }

    public function addPost(Request $req) {
        $data = new Productcafe;

        $data->Nama = $req->Nama;
        $data->Harga = $req->Harga;
        $data->Stock = $req->Stock;

        $data->save();

        return ['success' => true];
    }

    public function edit($id) {
        $data = Productcafe::findOrFail($id);

        return view('productcafe.edit', ['prod' => $data]);
    }

    public function editPost(Request $req) {
        $data = Productcafe::findOrFail($req->pid);

        $data->Nama = $req->Nama;
        $data->Harga = $req->Harga;
        $data->Stock = $req->Stock;

        $data->save();

        return ['success' => true];
    }
}
