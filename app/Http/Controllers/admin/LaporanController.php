<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $tanggalAwal = $request->tanggal_awal ? Carbon::parse($request->tanggal_awal)->startOfDay() : now()->startOfMonth();
        $tanggalAkhir = $request->tanggal_akhir ? Carbon::parse($request->tanggal_akhir)->endOfDay() : now()->endOfMonth();

        $data = Transaction::with('customer.user', 'details.service')
            ->whereBetween('tanggal', [
                $tanggalAwal,
                $tanggalAkhir
            ])->where('status_pembayaran', 'lunas')
            ->get();

        $totalCustomer = $data->count();


        $bulan = $request->bulan ?? now()->month;

        $dataIncome = Transaction::select(
            DB::raw('DAY(tanggal) as hari'),
            DB::raw('SUM(total) as total_harian')
        )
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', now()->year)
            ->where('status_pembayaran', 'lunas')
            ->groupBy('hari')
            ->orderBy('hari')
            ->get();

        // Siapkan array untuk chart
        $labels = $dataIncome->pluck('hari'); // tanggal (1,2,3,...)
        $totals = $dataIncome->pluck('total_harian'); // income per hari

        $total = $totals->sum();
        return view('admin.laporan.index', compact('data', 'totalCustomer', 'tanggalAwal', 'tanggalAkhir', 'bulan', 'labels', 'totals', 'dataIncome'));
    }


    public function print(Request $request)
    {

        $tanggalAwal = $request->tanggal_awal ? Carbon::parse($request->tanggal_awal)->startOfDay() : now()->startOfMonth();
        $tanggalAkhir = $request->tanggal_akhir ? Carbon::parse($request->tanggal_akhir)->endOfDay() : now()->endOfMonth();

        // $tanggal = $request->tanggal ?? now()->toDateString();

        $data = Transaction::with('customer.user', 'details.service')->whereBetween('tanggal', [
            $tanggalAwal,
            $tanggalAkhir
        ])
            ->where('status_pembayaran', 'lunas')
            ->get();


        $totalCustomer = $data->count();

        // Hitung total pendapatan dari semua service di semua transaksi
        $totalPendapatan = $data->sum(function ($transaction) {
            return $transaction->details->sum(function ($detail) {
                return $detail->service->harga ?? 0;
            });
        });

        return view('admin.laporan.print', compact('data', 'totalCustomer', 'totalPendapatan', 'tanggalAwal', 'tanggalAkhir'));
    }
}
