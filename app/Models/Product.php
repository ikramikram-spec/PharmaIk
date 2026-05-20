<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'PPV',
        'PPH',
        'category_id',
        'supplier_id',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function stock() {
        return $this->hasOne(Stock::class);
    }

    public function saleDetails() {
        return $this->hasMany(SaleDetail::class);
    }

    public function purchaseDetails() {
        return $this->hasMany(PurchaseDetail::class);
    }
}
