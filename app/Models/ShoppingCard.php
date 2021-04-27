<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor',
        'client_id',
        'product',
        'quantity',
        'is_buyed',
        'final_price',
    ];
}
