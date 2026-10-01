<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{

    protected $table = 'kasir';

    protected $fillable = [
        'id_user',
        'no_hp',
        'alamat'
    ];

    //relasi dengan table transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_kasir');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
