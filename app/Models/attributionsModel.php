<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attributionsModel extends Model
{
    use HasFactory;

    protected $table = 'attributions';
    protected $fillable = 
    [
        'id_ordi',
        'id_client',
        'horraire',
        'date',
    ];

    public function client(){
        return $this->belongsTo(ClientsModel::class, 'id_client');
    }

    
}
