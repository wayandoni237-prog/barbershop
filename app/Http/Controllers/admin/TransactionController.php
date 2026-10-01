<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\Kasir;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with([
            'customer.user',
            'kasir.user',
            'booking',
            'barber'
        ])->latest()->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($bookingId)
    {
        $booking = Booking::with([
            'customer.user',
            'barber',
            'details.service'
        ])->findOrFail($bookingId);

        return view('admin.transactions.create', compact('booking'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $bookingId)
    {
        try {


        $request->validate([
            'metode_bayar' => 'required|in:tunai,qris',
        ]);

        $booking = Booking::with('details')->findOrFail($bookingId);

        if (Transaction::where('id_booking', $booking->id)->exists()) {
            return back()->with('error', 'Booking already has transaction')
            ->with('booking_id', $booking->id);
            
        }

        $kasir = Auth::user()->kasir;

        if (!$kasir) {
            return back()->with('error', 'This account is not cashier');
        }

        $total = $booking->details->sum('harga');


        $transaction = Transaction::create([
            'id_customer' => $booking->id_customer,
            'id_barber' => $booking->id_barber,
            'id_kasir' => $kasir->id,
            'id_booking' => $booking->id,
            'tanggal' => now(),
            'metode_bayar' => $request->metode_bayar,
            'total' => $total,
            'status_layanan' => 'proses',
            'status_pembayaran' => 'pending'
        ]);

        foreach ($booking->details as $detail) {
            TransactionDetail::create([
                'id_transaction' => $transaction->id,
                'id_service' => $detail->id_service,
                'harga' => $detail->harga
            ]);
        }

        $status = Booking::findOrFail($bookingId);

        $status->update([
            'status' => 'selesai',
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction successfully proccess')->with('toast','booking_transaction');
        } catch (\Exception $e) {
            return redirect()->route('bookings.index')->with('error', 'Failed to process transaction')->with('toast','booking_transaction_error');
        }
    }


    public function complete($transactionId)
    {
        try {


        $transaction = Transaction::findOrFail($transactionId);

        $transaction->update([
            'status_layanan' => 'selesai',
            'status_pembayaran' => 'lunas'
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction finished')->with('toast','transaction_finish');
        } catch (\Exception $e) {
            return redirect()->route('transactions.index')->with('error', 'Failed to finish transaction')->with('toast','transaction_finish_error');
        }
    }
}
