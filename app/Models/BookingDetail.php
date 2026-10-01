<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{

    protected $fillable = [
    'id_booking',
    'id_service',
    'harga',
    'created_by',
    'updated_by'
    ];

    //relasi id dengan table bookings 
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }

    //relasi id dengan table services
    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
}
