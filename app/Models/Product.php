<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id'; // <- aqui dizemos qual é a chave primária

    public $timestamps = false; // <- se você não tiver `created_at` e `updated_at`

    protected $fillable = [
        'product_name',
        'product_qtty',
        'product_cost_price',
        'product_price',
    ];

}
