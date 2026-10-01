<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminreportController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // ===== LAPORAN CUSTOMER BULAN INI =====
        $customerRepeat = DB::table('transactions')
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->select('id_customer', DB::raw('COUNT(*) as total'))
            ->groupBy('id_customer')
            ->having('total', '>', 1)
            ->get()->count();

        $customerBaru = DB::table('transactions')
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->select('id_customer', DB::raw('COUNT(*) as total'))
            ->groupBy('id_customer')
            ->having('total', '=', 1)
            ->get()->count();

        $totalCustomer = $customerRepeat + $customerBaru;

        // ===== PESANAN HARI INI =====
        $pesananSelesai = DB::table('transactions')
            ->whereDate('tanggal', Carbon::today())
            ->where('status_layanan', 'selesai')
            ->count();

        $pesananTidakSelesai = DB::table('transactions')
            ->whereDate('tanggal', Carbon::today())
            ->where('status_layanan', 'proses')
            ->count();

        // ===== INCOME SUMMARY =====
        $incomeBulanIni = DB::table('transactions')
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->where('status_pembayaran', 'lunas')
            ->sum('total');

        $incomeTahunIni = DB::table('transactions')
            ->whereYear('tanggal', $tahunIni)
            ->where('status_pembayaran', 'lunas')
            ->sum('total');

        // ===== CHART MINGGUAN — 7 hari terakhir =====
        $weeklyLabels = [];
        $weeklyData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $weeklyLabels[] = $date->format('d M');
            $weeklyData[]   = (int) DB::table('transactions')
                ->whereDate('tanggal', $date)
                ->where('status_pembayaran', 'lunas')
                ->sum('total');
        }

        // ===== CHART BULANAN — 12 bulan tahun ini =====
        $bulanNama    = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $monthlyLabels = [];
        $monthlyData   = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyLabels[] = $bulanNama[$i - 1] . ' ' . $tahunIni;
            $monthlyData[]   = (int) DB::table('transactions')
                ->whereYear('tanggal', $tahunIni)
                ->whereMonth('tanggal', $i)
                ->where('status_pembayaran', 'lunas')
                ->sum('total');
        }

        // ===== CHART TAHUNAN — 5 tahun terakhir =====
        $yearlyLabels = [];
        $yearlyData   = [];
        for ($i = 4; $i >= 0; $i--) {
            $year = $tahunIni - $i;
            $yearlyLabels[] = (string) $year;
            $yearlyData[]   = (int) DB::table('transactions')
                ->whereYear('tanggal', $year)
                ->where('status_pembayaran', 'lunas')
                ->sum('total');
        }

        return view('admin.admindashboard', compact(
            'customerRepeat',
            'customerBaru',
            'totalCustomer',
            'pesananSelesai',
            'pesananTidakSelesai',
            'incomeBulanIni',
            'incomeTahunIni',
            'weeklyLabels',
            'weeklyData',
            'monthlyLabels',
            'monthlyData',
            'yearlyLabels',
            'yearlyData'
        ));
    }
}