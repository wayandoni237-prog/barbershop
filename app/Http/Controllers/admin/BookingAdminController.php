<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingAdminController extends Controller
{
    public function index()
    {
        $bookings = DB::table('bookings')
            ->join('customers', 'bookings.id_customer', '=', 'customers.id')
            ->join('users', 'customers.id_user', '=', 'users.id')
            ->leftJoin('barbers', 'bookings.id_barber', '=', 'barbers.id')
            ->leftJoin('booking_details', 'bookings.id', '=', 'booking_details.id_booking')
            ->leftJoin('transactions', 'bookings.id', '=', 'transactions.id_booking')
            ->select(
                'bookings.id',
                'bookings.tanggal',
                'bookings.status',
                'bookings.id_barber',
                'users.username',
                'users.email',
                'barbers.nama as nama_barber',
                DB::raw('SUM(booking_details.harga) as total_harga'),
                'transactions.id as transaction_id'
            )
            ->groupBy(
                'bookings.id',
                'bookings.tanggal',
                'bookings.status',
                'bookings.id_barber',
                'users.username',
                'users.email',
                'barbers.nama',
                'transactions.id'
            )
            ->orderBy('bookings.tanggal', 'desc')
            ->get();

        $barbers = DB::table('barbers')->get();

        return view('admin.bookings.index', compact('bookings', 'barbers'));
    }

    public function edit($id)
    {
        $booking = DB::table('bookings')
            ->join('customers', 'bookings.id_customer', '=', 'customers.id')
            ->join('users', 'customers.id_user', '=', 'users.id')
            ->leftJoin('barbers', 'bookings.id_barber', '=', 'barbers.id')
            ->select(
                'bookings.id',
                'bookings.tanggal',
                'bookings.status',
                'bookings.id_barber',
                'users.username',
                'users.email',
                'barbers.nama as nama_barber'
            )
            ->where('bookings.id', $id)
            ->first();

        if (!$booking) {
            return redirect()->route('bookings.index')->with('error', 'Booking data not found.');
        }

        $barbers = DB::table('barbers')->get();

        return view('admin.bookings.edit', compact('booking', 'barbers'));
    }

    public function update(Request $request, $id)
    {
        try {


        $request->validate([
            'tanggal_booking' => 'required|date',
            'jam_booking'     => 'required|in:10:00,11:00,13:00,14:00,15:00,16:00,19:00',
            'id_barber'       => 'nullable|exists:barbers,id',
            'status'          => 'required|in:menunggu,diterima,batal',
        ]);

        $tanggal = $request->tanggal_booking . ' ' . $request->jam_booking . ':00';

        DB::table('bookings')->where('id', $id)->update([
            'tanggal'    => $tanggal,
            'id_barber'  => $request->id_barber ?? null,
            'status'     => $request->status,
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking data successfully updated.')->with('toast','booking_edit');
        } catch (\Exception $e) {
            return redirect()->route('bookings.index')->with('error', 'Failed to edit booking data.')->with('toast','booking_edit_error');
        }
    }

    public function accept($id)
    {
        try {


        DB::table('bookings')->where('id', $id)->update([
            'status'     => 'diterima',
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking accepted.')->with('toast','booking_accept');
        } catch (\Exception $e) {
            return redirect()->route('bookings.index')->with('error', 'Failed to accept booking.')->with('toast','booking_accept_error');
        }
    }

    public function reject($id)
    {
        try {


        DB::table('bookings')->where('id', $id)->update([
            'status'     => 'batal',
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking rejected.')->with('toast','booking_reject');
        } catch (\Exception $e) {
            return redirect()->route('bookings.index')->with('error', 'Failed to reject booking.')->with('toast','booking_reject_error');
        }
    }
}