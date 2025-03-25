<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        date_default_timezone_set("Europe/Madrid");
        $hora = date('H:i:s', time());
        Reserva::where('horaFin', '<', $hora)->delete();

        $reservas = Reserva::all();
        return view('index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        date_default_timezone_set("Europe/Madrid");
        return view('reservar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $existeReserva = Reserva::where('carro', $request->carro)->where(function($query) use ($request) {
            $query->whereBetween('horaInicio', [$request->horaInicio, $request->horaFin])
            ->orWhereBetween('horaFin', [$request->horaInicio, $request->horaFin])
            ->orWhere(function($query) use ($request) {
                $query->where('horaInicio', '<', $request->horaInicio)
                ->where('horaFin', '>', $request->horaFin);
            });
        })
        ->exists();

    if ($existeReserva) {
        return redirect()->route('reservas.create')->with('error', 'El carro ya está reservado dentro del horario.');
    } else {
        Reserva::create([
            'carro' => $request->carro,
            'profesor' => $request->profesor,
            'horaInicio' => $request->horaInicio,
            'horaFin' => $request->horaFin,
        ]);

        return redirect()->route('reservas.index')->with('success', 'Reserva creada correctamente.');
    }
}


    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        //
    }

    public function cerrarSesion() 
    {
        //
        return view('welcome');
    }
}
