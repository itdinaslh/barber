<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function index() {
        $data = Product::select(['id', 'ProductName', 'Harga', 'Komisi', 'Stock'])->get();
        foreach($data as $v) {
            $v->Harga = number_format($v->Harga, 0, ',', '.');
            $v->Komisi = number_format($v->Komisi, 0, ',', '.');
            $v->Stock = number_format($v->Stock, 0, ',', '.');
        }
        return view('product.index', ['prod' => $data]);
    }

    public function ajaxProduct() {
        $data = Product::select(['id', 'ProductName', 'Harga', 'Komisi', 'Stock']);

        return Datatables::of($data)
                          ->addColumn('action', function($data) {
                              return '<a href="#" class="btn btn-xs btn-success" style="width:100%;">Edit</a>';
                            })
        ->make(true);
    }

    public function addNew() {
        return view('product.add');
    }

    public function addPost(Request $req) {
        $prod = new Product;

        $prod->ProductName = $req->ProductName;
        $prod->Harga = $req->Harga;
        $prod->Komisi = $req->Komisi;
        $prod->Stock = $req->Stock;
        $prod->CreatedBy = $req->uid;
        $prod->ModifiedBy = $req->uid;
        $prod->save();

        return ['success' => true];
    }

    public function edit($id) {
        $data = Product::findOrFail($id);

        return view('product.edit', ['prod' => $data]);
    }

    public function editPost(Request $req) {
        $prod = Product::findOrFail($req->pid);

        $prod->ProductName = $req->ServiceName;
        $prod->Harga = $req->Harga;
        $prod->Komisi = $req->Komisi;
        $prod->Stock = $req->Stock;
        $prod->ModifiedBy = $req->uid;
        $prod->save();

        return ['success' => true];
    }
}
