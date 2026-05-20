<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'client_name',
        'email',
        'contact',
        'credit',
        'address',
    ];
    
    public function sales() {
        return $this->hasMany(Sale::class);
    }
}
