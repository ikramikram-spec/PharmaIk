<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'company_name',
        'localisation',
        'email',
        'contact',
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }
}
