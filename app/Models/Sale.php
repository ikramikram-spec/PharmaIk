<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'date_selling',
        'total_amount',
        'client_id',
        'user_id',
        'note',
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function saleDetails() {
        return $this->hasMany(SaleDetail::class);
    }
}
