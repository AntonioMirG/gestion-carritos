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
        $fecha = date('y-m-d H:i:s', time());
        Reserva::where('fin', '<', $fecha)->delete();

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

        $inicio = \Carbon\Carbon::parse($request->inicio);
        $fin = \Carbon\Carbon::parse($request->fin);

        // Inicio no puede ser mayor que la fecha actual
        if ($inicio->isBefore(\Carbon\Carbon::now())) {
            return redirect()->route('reservas.create')->with('error', 'La fecha de inicio no puede ser anterior a la fecha actual.');
        }

        // Fin no puede ser menor que inicio
        if ($fin->isBefore($inicio)) {
            return redirect()->route('reservas.create')->with('error', 'La fecha de fin debe ser posterior a la fecha de inicio.');
        }

        // Ya hay una reserva del carro dentro del horario
        $existeReserva = Reserva::where('carro', $request->carro)
        ->where(function($query) use ($inicio, $fin) {
            $query->whereBetween('inicio', [$inicio, $fin])
                  ->orWhereBetween('fin', [$inicio, $fin])
                  ->orWhere(function($query) use ($inicio, $fin) {
                    $query->where('inicio', '<', $inicio)
                          ->where('fin', '>', $fin);
            });
        })
        ->exists();

        if ($existeReserva) {
            return redirect()->route('reservas.create')->with('error', 'El carro ya está reservado en ese horario.');
        }
            Reserva::create([
                'carro' => $request->carro,
                'profesor' => $request->profesor,
                'inicio' => $inicio,
                'fin' => $fin,
            ]);

            return redirect()->route('reservas.index')->with('success', 'Reserva creada correctamente.');
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
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();
        return redirect()->route('reservas.index')->with('success', 'Reserva eliminada correctamente.');
    }

    public function cerrarSesion() 
    {
        //
        return view('welcome');
    }
}
