<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    protected $fillable = [
        'type',
        'reason',
        'note',
        'date_return',
        'user_id',
        'supplier_id',
        'sale_id',
    ];

    public function user(){
        return $this -> belongsTo(User::class);
    }

    public function supplier(){
        return $this -> belongsTo(Supplier::class);
    }

    public function sale(){
        return $this -> belongsTo(Sale::class);
    }
}
