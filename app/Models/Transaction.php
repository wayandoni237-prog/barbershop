<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'id_customer',
        'id_barber',
        'id_kasir',
        'id_booking',
        'tanggal',
        'metode_bayar',
        'total',
        'status_layanan',
        'status_pembayaran'
    ];

    

    //relasi id dengan table transaction_details
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'id_transaction');
    }

    //relasi id dengan table bookings
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }

    //relasi id dengan table customer
    public function customer()
    { 
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    //relasi id dengan table barbers
    public function barber()
    {
        return $this->belongsTo(Barber::class, 'id_barber');
    }

    //relasi dengan table kasir
    public function kasir()
    {
        return $this->belongsTo(Kasir::class, 'id_kasir');
    }

    protected $casts = [
        'tanggal' => 'datetime'
    ];
}
