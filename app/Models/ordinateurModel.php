<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ordinateurModel extends Model
{
    protected $table = "ordinateurs";
    protected $fillable = ['nom'];

    public function attributions(){
        return $this->hasMany(attributionsModel::class, 'id_ordi');
    }
}
