<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalCustomer = DB::table('customers')->count();

        $totalBarber = DB::table('barbers')->count();

        $bookingHariIni = DB::table('bookings')
            ->whereDate('tanggal', Carbon::today())
            ->count();

        $incomeBulanIni = DB::table('transactions')
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->where('status_pembayaran', 'lunas')
            ->sum('total');

        $bookingTerbaru = DB::table('bookings')
            ->join('customers', 'bookings.id_customer', '=', 'customers.id')
            ->join('users', 'customers.id_user', '=', 'users.id')
            ->select('users.username', 'bookings.tanggal', 'bookings.status')
            ->orderBy('bookings.created_at', 'desc')
            ->limit(5)
            ->get();

        $barbers = DB::table('barbers')->get();

        $services = DB::table('services')->get();

        return view('admin.admindashboard', compact(
            'totalCustomer',
            'totalBarber',
            'bookingHariIni',
            'incomeBulanIni',
            'bookingTerbaru',
            'barbers',
            'services'
        ));
    }
}