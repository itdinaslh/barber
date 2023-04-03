<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class LaporanExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    public function __construct($first, $end) {
        $this->Awal = $first;
        $this->Akhir = $end;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        // $prod = DB::table('transbbproducts as a')
        //           ->join('transactions as b', 'a.TrxID', '=', 'b.id')
        //           ->join('product as c', 'a.ProductID', '=', 'c.id')
        //           ->join('bbman as d', 'a.BbID', '=', 'd.id')
        //           ->select('a.id', 'a.TrxID',DB::raw('0 as Type'), 'c.ProductName as ServName', 'd.Nama as BbName', 'a.Price', 'a.Qty', DB::raw('a.Price * a.Qty as Total'), DB::raw('DATE(a.created_at) as stat_day'))
        //           ->whereBetween('a.created_at', [$this->Awal, $this->Akhir]);

        // $data = DB::table('transbbdetails as a')
        //           ->join('transactions as b', 'a.TrxID', '=', 'b.id')
        //           ->join('bbman as d', 'a.BbID', '=', 'd.id')
        //           ->select('a.id', 'a.TrxID',DB::raw('1 as Type'), 'a.ServiceName as ServName', 'd.Nama as BbName', 'a.Price', 'a.Qty', DB::raw('a.Price * a.Qty as Total'), DB::raw('DATE(a.created_at) as stat_day'))
        //           ->whereBetween('b.created_at', [$this->Awal, $this->Akhir])
        //           ->union($prod);

        // $data= $data->orderBy('TrxID')->get();

        $data = DB::table('transactions as t')
                  ->join('payments as p', 't.PayMethod', '=', 'p.id')
                  ->join('customer as c', 't.MemberID', '=', 'c.id')
                  ->select(
                    DB::raw('DATE(t.created_at) as tanggal'),
                    't.id as TrxID',
                    't.TotalTrx',
                    't.DiscountID',
                    't.Discount as Discount(Rp)',
                    't.VoucherID',
                    't.VoucherVal as Voucher(Rp)',
                    'p.Name as Payment',
                    't.TotalPaid')
                    ->whereBetween('t.created_at', [$this->Awal, $this->Akhir])
                  ->get();

        return $data;
    }

    public function headings() : array {
        return [
            'Tanggal',
            'Trasaksi ID',
            'Total Transaksi',
            'Diskon ID',
            'Discount(Rp)',
            'VoucherID',
            'Voucher(Rp)',
            'Payment',
            'Subtotal',

        ];
    }
}
