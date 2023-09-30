<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

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
}
