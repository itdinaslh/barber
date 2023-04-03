<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Yajra\Datatables\Facades\Datatables;

class UserController extends Controller
{
    //
    public function index() {
        $data = DB::table('users as u')
                  ->join('positions as p', 'u.posid', '=', 'p.id' )
                  ->select(['u.id', 'u.username', 'u.name', 'p.PosName'])
                  ->get();

        return view('user.index', ['user' => $data]);
    }

    public function changeGet($id) {
        $data = User::findOrFail($id);

        return view('user.changepassword', ['user' => $data]);
    }
}
