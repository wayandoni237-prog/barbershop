<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $fillable = [
        'id_customer',
        'id_barber',
        'tanggal',
        'status',
        'created_by',
        'updated_by'
    ];

    //relaso dengan id customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    //relasi dengan id barber
    public function barber()
    {
        return $this->belongsTo(Barber::class, 'id_barber');
    }

    //relasi dengan table booking_details
    public function details()
    {
        return $this->hasMany(BookingDetail::class, 'id_booking');
    }

    //relasi id dengan table transactions
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id_booking');
    }
}
