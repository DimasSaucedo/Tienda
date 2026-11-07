<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio_Rines extends Model
{
    use HasFactory;
    protected $table = 'precio_rines';
    protected $guarded = [];

    public function imagenRin()
    {
        return $this->hasOne(Rines::class, 'id_precio_rines')->where('estado', 1);
    }
}
