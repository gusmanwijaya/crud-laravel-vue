<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transactions";
    protected $primaryKey = "id";
    protected $fillable = ['id', 'uuid', 'name', 'email', 'number', 'address', 'transaction_total', 'transaction_status'];

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class, 'transactions_id');
    }
}
