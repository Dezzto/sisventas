<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    public function detalles(){
        return $this->hasMany(detalleCompra::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

}
