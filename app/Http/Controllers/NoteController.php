<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Carbon\Carbon;
use DataTables;
use App\Models\Note;

class NoteController extends Controller
{
    //
    public function index() {
        return view('note.index');
    }

    public function ajaxData() {
        $data = DB::table('notes')
                  ->select('id', 'Title', 'Content', 'Active');

        return Datatables::of($data)
                         ->addColumn('action', function($data) {
                              return '<button type="button" class="btn btn-xs btn-success showMe" data-href="/notes/edit/'.$data->id.'" style="width:100%;">Edit</button> <br />
                                      <button type="button" class="btn btn-xs btn-warning activateMe" data-id="'.$data->id.'" style="width:100%;margin-top:3px;">Activate</button>';
                         })
                         ->make(true);
    }

    public function AddNew() {
        return view('note.add');
    }

    public function AddPost(Request $req) {
        $active = Note::where('Active', 1)
                      ->first();

        if (!is_null($active)) {
            if($req->Active == 1) {
                $active->Active = 0;
                $active->save();
            }
        }

        $data = new Note;
        $data->Title = $req->Title;
        $data->Content = $req->Content;
        $data->UserID = $req->uid;
        $data->Active = $req->Active;

        $data->save();

        return ['success' => true];
    }

    public function EditGet($id) {
        $data = Note::findOrFail($id);

        return view('note.edit', ['note' => $data]);
    }

    public function EditPost(Request $req) {
        $active = Note::where('Active', 1)
                      ->first();

        if (!is_null($active)) {
            if($req->Active == 1) {
                $active->Active = 0;
                $active->save();
            }
        }

        $data = Note::findOrFail($req->NoteID);

        if(is_null($data)) {
            return ['notfound' => true];
        }

        $data->Title = $req->Title;
        $data->Content = $req->Content;
        $data->Active = $req->Active;

        $data->save();

        return ['success' => true];
    }

    public function Activate($id) {
        $active = Note::where('Active', 1)
                      ->first();
        $active->Active = 0;
        $active->save();

        $data = Note::findOrFail($id);

        $data->Active = 1;

        $data->save();

        return ['success' => true];
    }
}
