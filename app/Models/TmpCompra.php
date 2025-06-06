<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpCompra extends Model
{
    use HasFactory;

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
