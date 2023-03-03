<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaledProducts extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function salesProducts()
    {
        return $this->hasMany(Sales::class);
    }
}
