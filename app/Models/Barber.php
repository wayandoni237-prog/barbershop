<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{

    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
        'image'
    ];

    //relasi id dengan table bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_barber');
    }

    //relasi id dengan table transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_barber');
    }
}
