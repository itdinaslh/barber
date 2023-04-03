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
                  ->orderBy('u.id', 'desc')
                  ->get();

        return view('user.index', ['user' => $data]);
    }

    public function changeGet($id) {
        $data = User::findOrFail($id);

        return view('user.changepassword', ['user' => $data]);
    }

    public function ChangePass(Request $req) {
        $data = User::findOrFail($req->uid);

        $data->password = bcrypt($req->password);

        $data->save();

        return ['success' => true];
    }

    public function Edit($id) {
        $data = User::findOrFail($id);
        $pos = DB::table('positions')
                 ->select('id','PosName')
                 ->get();

        return view('user.edit', ['user' => $data, 'pos' => $pos]);
    }

    public function EditPost(Request $req) {
        $user = User::findOrFail($req->uid);

        $level = $req->posid;

        if ($user->posid == 1 && $user->posid != $level) {
            return ['unavailable' => true];
        }

        $user->name = trim($req->name);
        $user->posid = $req->posid;

        $user->save();

        return ['success' => true];
    }

    public function AddNew() {
        $pos = DB::table('positions')
                 ->select('id', 'PosName')
                 ->get();
        return view('user.add', ['pos' => $pos]);
    }

    public function AddPost(Request $req) {
        $data = new User;

        $data->username = trim($req->username);
        $data->name = trim($req->name);
        $data->password = bcrypt($req->password);
        $data->posid = $req->posid;

        $data->save();

        $cek = User::select('id')
                   ->orderBy('id', 'desc')
                   ->first();

        $row = User::findOrFail($cek->id);

        $id = (string)$cek->id;

        if(strlen($id) == 1) {
            $kode = $req->level.'00'.$id;
        } elseif (strlen($id) == 2) {
            $kode = $req->level.'0'.$id;
        } else {
            $kode = $req->level.$id;
        }

        $row->code = $kode;

        $row->save();

        return ['success' => true];

    }
}
