<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arqueo extends Model
{
    use HasFactory;

    public function movimientos(){
        return $this->hasMany(MovimientoCaja::class);
    }
}
