<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reserva extends Model
{
    //
    protected $fillable = ['carro', 'profesor', 'inicio', 'fin'];

    public function getInicioAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }

    public function getFinAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }
}
