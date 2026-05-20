<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'quantity',
        'PPH_edited',
        'expiry_date',
        'product_id',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
