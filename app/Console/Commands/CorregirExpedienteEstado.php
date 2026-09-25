<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tramite;
use App\Models\SeguimientoTramite;
use App\Models\AreaTramite;

class CorregirExpedienteEstado extends Command
{
    protected $signature = 'tramites:corregir-expediente {expediente : Número (ej: EXP-2026-000035)} {area_destino_id : ID del área destino}';
    protected $description = 'Corrige estado y área de un expediente (ej: poner derivado con área correcta)';

    public function handle()
    {
        $expediente = $this->argument('expediente');
        $areaDestinoId = (int) $this->argument('area_destino_id');

        $tramite = Tramite::where('numero_expediente', $expediente)->first();
        if (!$tramite) {
            $this->error("Expediente {$expediente} no encontrado.");
            return Command::FAILURE;
        }

        $areaDestino = AreaTramite::find($areaDestinoId);
        if (!$areaDestino) {
            $this->error("Área ID {$areaDestinoId} no encontrada.");
            return Command::FAILURE;
        }

        $areaOrigenId = $tramite->area_origen_id;

        $tramite->update([
            'estado' => 'derivado',
            'area_actual_id' => $areaDestinoId,
            'area_anterior_id' => $areaOrigenId,
            'pendiente_recepcion' => true,
            'ultimo_movimiento_at' => now(),
        ]);

        SeguimientoTramite::create([
            'tramite_id' => $tramite->id,
            'usuario_id' => $tramite->creado_por_id ?? 1,
            'accion' => 'derivado',
            'descripcion' => 'Corrección manual: documento derivado a ' . $areaDestino->nombre,
            'estado_nuevo' => 'derivado',
            'area_origen_id' => $areaOrigenId,
            'area_destino_id' => $areaDestinoId,
            'visible_ciudadano' => true,
        ]);

        $this->info("✅ {$expediente}: estado→derivado, área actual→{$areaDestino->nombre} (ID:{$areaDestinoId})");
        return Command::SUCCESS;
    }
}
