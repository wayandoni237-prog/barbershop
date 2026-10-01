<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{

    protected $fillable = [
        'id_transaction',
        'id_service',
        'harga'
    ];

    //relasi id dengan table transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaction');
    }

    //relasi id dengan table services
    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
}
