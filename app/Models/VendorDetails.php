<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'cultur_coordinate',
        'shop_name', 'profile_img_url'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
