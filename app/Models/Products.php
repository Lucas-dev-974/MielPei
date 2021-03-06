<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    
    protected  $fillable = [
        'price',
        'quantity',
        'details',
        'vendor_id',
        'name'
    ];

    public function vendor(){
        return $this->belongsTo(User::class);
    }
}
