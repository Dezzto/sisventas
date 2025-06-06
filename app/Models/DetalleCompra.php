<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    public function compra(){
        return $this->belongsTo(Compra::class);
    }

    /*public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }*/

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
