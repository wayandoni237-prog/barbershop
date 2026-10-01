<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = [
        'nama_service',
        'harga',
        'estimasi_menit',
        'is_active'
    ];

//relasi id dengan table booking_details
public function bookingDetails()
{
    return $this->hasMany(BookingDetail::class, 'id_service');
}

//relasi id dengan table transaction_details
public function transactionDetails()
{
    return $this->hasMany(TransactionDetail::class, 'id_service');
}
}
