<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    //
    protected $fillable = ['carro', 'profesor', 'horaInicio', 'horaFin'];
}
