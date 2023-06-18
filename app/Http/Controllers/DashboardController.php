<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class DashboardController extends Controller
{
    //
    public function index() {
        $currentMonth = date('m');
        $today = Transaction::whereDate('created_at', now()->today())->count();
        $todaytotal = Transaction::whereDate('created_at', now()->today())->sum('TotalPaid');
        $week = Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $weektotal = Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('TotalPaid');
        $month = Transaction::whereMonth('created_at', $currentMonth)->count();
        $monthtotal = Transaction::whereMonth('created_at', $currentMonth)->sum('TotalPaid');
        return view('dashboard.index', ['today'=> $today, 'week'=>$week, 'month'=>$month,
        'todaytotal'=> $todaytotal, 'weektotal'=>$weektotal, 'monthtotal'=>$monthtotal
    ]);
    }
}
