<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = "transaction_details";
    protected $primaryKey = "id";
    protected $fillable = ['id', 'transactions_id', 'products_id'];

    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'transactions_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
}
