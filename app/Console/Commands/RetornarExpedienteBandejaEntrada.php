<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tramite;
use App\Models\User;

class RetornarExpedienteBandejaEntrada extends Command
{
    protected $signature = 'tramites:retornar-bandeja-entrada 
                            {expediente : Número de expediente (ej: EXP-2026-000058)} 
                            {--motivo= : Motivo opcional del retorno}';
    protected $description = 'Retorna un expediente al estado inicial de bandeja de entrada (área de origen, pendiente de recepción)';

    public function handle()
    {
        $numero = $this->argument('expediente');
        $motivo = $this->option('motivo');

        $tramite = Tramite::where('numero_expediente', $numero)->first();
        if (!$tramite) {
            $this->error("Expediente {$numero} no encontrado.");
            return Command::FAILURE;
        }

        $this->info("Expediente: {$tramite->numero_expediente}");
        $this->info("Área actual: " . ($tramite->areaActual?->nombre ?? 'N/A'));
        $this->info("Área origen:  " . ($tramite->areaOrigen?->nombre ?? 'N/A'));
        $this->info("Estado actual: {$tramite->estado}");

        if (!$tramite->area_origen_id) {
            $this->error('El expediente no tiene área de origen. No se puede retornar.');
            return Command::FAILURE;
        }

        $usuario = User::find($tramite->creado_por_id) ?? User::first();
        if (!$usuario) {
            $this->error('No hay usuario para registrar el seguimiento.');
            return Command::FAILURE;
        }

        try {
            $tramite->retornarAEstadoInicialBandejaEntrada($usuario, $motivo);
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $this->info("✅ Expediente {$numero} retornado a bandeja de entrada (área de origen: {$tramite->areaOrigen?->nombre}).");
        $this->info('   Queda pendiente de recepción en esa área.');
        return Command::SUCCESS;
    }
}
