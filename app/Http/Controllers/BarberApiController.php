<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bbman;

class BarberApiController extends Controller
{
    //
    public function index() {
        $data = Bbman::all();

        $barb = array();

        $barb['list'] = $data;

        return $data;
    }
}
