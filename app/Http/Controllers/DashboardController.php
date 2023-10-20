<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use DB;


class DashboardController extends Controller
{
    //
    public function index() {
        $currentMonth = date('m');
        $today = Transaction::whereDate('created_at', now()->today())->where('Lock', '1')->count();
        $todaytotal = Transaction::whereDate('created_at', now()->today())->where('Lock', '1')->sum('TotalPaid');
        $week = Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->where('Lock', '1')->count();
        $weektotal = Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('TotalPaid');
        $month = Transaction::whereMonth('created_at', $currentMonth)->where('Lock', '1')->count();
        $monthtotal = Transaction::whereMonth('created_at', $currentMonth)->where('Lock', '1')->sum('TotalPaid');

        return view('dashboard.index', ['today'=> $today, 'week'=>$week, 'month'=>$month,
        'todaytotal'=> $todaytotal, 'weektotal'=>$weektotal, 'monthtotal'=>$monthtotal
        ]);
    }

    Public function ajax() {
        config()->set('database.connections.mysql.strict', false);
        $data = Transaction::select(
            DB::raw("(DATE_FORMAT(created_at, '%m-%Y')) as x"),
            DB::raw("(count(id)) as y"),
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
            ->limit(12)
            ->get();
        return response()->json($data);
    }
}
