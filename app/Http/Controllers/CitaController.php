<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Servicio;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Formulario para agendar cita
     */
    public function crear()
    {
        $servicios = Servicio::where('activo', true)->orderBy('nombre')->get();
        return view('public.citas-crear', compact('servicios'));
    }

    /**
     * Guardar cita desde el formulario público
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'cliente_nombre' => 'required|string|max:255',
            'cliente_email' => 'required|email|max:255',
            'cliente_telefono' => 'required|string|max:20',
            'cliente_dni' => 'nullable|string|max:15',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|string|regex:/^\d{1,2}:\d{2}$/',
            'tipo' => 'required|in:consulta,tramite,audiencia,otro',
            'area' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $fechaInicio = \Carbon\Carbon::parse($request->fecha . ' ' . $request->hora);
        $fechaFin = $fechaInicio->copy()->addHour();

        // Evitar doble reserva en el mismo horario
        $existe = Cita::whereNotIn('estado', ['cancelada'])
            ->where('fecha_inicio', $fechaInicio)
            ->exists();

        if ($existe) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'El horario seleccionado no está disponible. Por favor elige otra fecha u hora.');
        }

        Cita::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'area' => $request->area,
            'cliente_nombre' => $request->cliente_nombre,
            'cliente_email' => $request->cliente_email,
            'cliente_telefono' => $request->cliente_telefono,
            'cliente_dni' => $request->cliente_dni,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'tipo' => $request->tipo,
            'estado' => 'pendiente',
            'color' => match ($request->tipo) {
                'consulta' => '#007bff',
                'tramite' => '#28a745',
                'audiencia' => '#ffc107',
                default => '#6c757d',
            },
        ]);

        return redirect()->route('public.citas.crear')
            ->with('success', 'Tu cita ha sido agendada correctamente. Te contactaremos para confirmarla.');
    }
}
