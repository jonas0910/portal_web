<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tramite;

class CorregirExpedientesRecuperados extends Command
{
    protected $signature = 'tramites:corregir-recuperados {expediente? : Número opcional (ej: EXP-2026-000048). Sin argumento corrige todos}';
    protected $description = 'Corrige expedientes recuperados o documentos de respuesta a estado=en_proceso para que muestren En proceso y Pend. derivar';

    public function handle()
    {
        $expediente = $this->argument('expediente');

        // 1) Recuperados con estado=registrado
        $queryRecup = Tramite::where('estado', 'registrado')
            ->whereHas('seguimientos', fn ($q) => $q->where('accion', 'recuperado'));
        if ($expediente) {
            $queryRecup->where('numero_expediente', $expediente);
        }
        $recuperados = $queryRecup->get();

        // 2) Documentos de respuesta (hijos) con estado=registrado o recibido que no están derivados
        $queryHijos = Tramite::whereNotNull('tramite_padre_id')
            ->where('estado', '!=', 'derivado')
            ->whereIn('estado', ['registrado', 'recibido']);
        if ($expediente) {
            $queryHijos->where('numero_expediente', $expediente);
        }
        $hijos = $queryHijos->get();

        $todos = $recuperados->merge($hijos)->unique('id');
        if ($todos->isEmpty()) {
            $this->info('No hay expedientes para corregir.');
            return Command::SUCCESS;
        }

        foreach ($todos as $tramite) {
            $tramite->update(['estado' => 'en_proceso']);
            $this->info("✅ {$tramite->numero_expediente}: estado → en_proceso");
        }

        $this->info("\nCorregidos: " . $todos->count() . " expediente(s).");
        return Command::SUCCESS;
    }
}
