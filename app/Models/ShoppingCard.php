<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCard extends Model
{
    use HasFactory;

    private $fillable = [
        'quantity',
        'is_buyed',
        'total_price'
    ];
}
