<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'no_hp',
        'alamat'
    ];

    //relasi id dengan table users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    //relasi id dengan table bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_customer');
    }

    //relasi id dengan table transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_customer');
    }
}