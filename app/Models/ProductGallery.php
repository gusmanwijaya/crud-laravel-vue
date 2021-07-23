<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    protected $table = "product_galleries";
    protected $primaryKey = "id";
    protected $fillable = ['id', 'products_id', 'photo', 'is_default'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
}
