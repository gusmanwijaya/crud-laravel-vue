<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $primaryKey = "id";
    protected $fillable = ['id', 'name', 'slug', 'type', 'description', 'price', 'quantity'];

    public function product_galleries()
    {
        return $this->hasMany(ProductGallery::class, 'products_id');
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class, 'transactions_id');
    }
}
