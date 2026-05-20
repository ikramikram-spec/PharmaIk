<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'date_ordering',
        'date_delivering',
        'total_amount',
        'supplier_id',
        'user_id',
        'statut',
        'note',
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function purchaseDetails() {
        return $this->hasMany(PurchaseDetail::class);
    }
}
