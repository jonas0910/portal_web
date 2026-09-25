<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tramite;
use App\Models\SeguimientoTramite;
use App\Models\CopiaTramite;

class CorregirExpedientesDerivados extends Command
{
    protected $signature = 'tramites:corregir-expedientes-derivados {expediente? : Número de expediente (ej: EXP-2026-000029)}';
    protected $description = 'Corrige expedientes que tienen documento derivado pero estado/área incorrectos';

    public function handle()
    {
        $this->info('Corrigiendo expedientes con documentos derivados...');

        $corregidos = 0;

        // Caso 1: Hijo (documento) con estado registrado pero tiene copias enviadas → tratar como derivado
        if ($expediente = $this->argument('expediente')) {
            $tramite = Tramite::where('numero_expediente', $expediente)->first();
            if ($tramite && $tramite->tramite_padre_id && $tramite->estado === 'registrado') {
                $primeraCopia = CopiaTramite::where('tramite_id', $tramite->id)->orderBy('created_at')->first();
                if ($primeraCopia && $primeraCopia->area_destino_id) {
                    $areaDestino = $primeraCopia->area_destino_id;
                    $areaOrigen = $tramite->area_actual_id;
                    $tramite->update([
                        'estado' => 'derivado',
                        'area_anterior_id' => $areaOrigen,
                        'area_actual_id' => $areaDestino,
                        'pendiente_recepcion' => true,
                        'ultimo_movimiento_at' => $primeraCopia->created_at ?? now(),
                    ]);
                    SeguimientoTramite::create([
                        'tramite_id' => $tramite->id,
                        'usuario_id' => $primeraCopia->usuario_envia_id,
                        'accion' => 'derivado',
                        'estado_nuevo' => 'derivado',
                        'area_origen_id' => $areaOrigen,
                        'area_destino_id' => $areaDestino,
                        'descripcion' => 'Documento derivado (corregido desde copia enviada).',
                        'visible_ciudadano' => true,
                        'created_at' => $primeraCopia->created_at ?? now(),
                    ]);
                    $this->line("  Expediente {$tramite->numero_expediente} (documento): estado→derivado, área destino→{$areaDestino}");
                    $corregidos++;

                    $padre = Tramite::find($tramite->tramite_padre_id);
                    if ($padre && $padre->estado !== 'derivado') {
                        $padre->update(['estado' => 'derivado']);
                        SeguimientoTramite::create([
                            'tramite_id' => $padre->id,
                            'usuario_id' => $primeraCopia->usuario_envia_id,
                            'accion' => 'derivado',
                            'estado_nuevo' => 'derivado',
                            'area_origen_id' => $areaOrigen,
                            'area_destino_id' => $areaDestino,
                            'descripcion' => 'Documento de respuesta derivado. Expediente atendido. (Corregido)',
                            'visible_ciudadano' => true,
                            'created_at' => $primeraCopia->created_at ?? now(),
                        ]);
                        $this->line("  Expediente {$padre->numero_expediente} (padre): estado→derivado, área destino→{$areaDestino}");
                        $corregidos++;
                    }
                    $this->info("✅ Corregidos {$corregidos} expedientes.");
                    return Command::SUCCESS;
                }
            }
        }

        $padres = collect();

        if ($expediente = $this->argument('expediente')) {
            $tramite = Tramite::where('numero_expediente', $expediente)->first();
            if ($tramite) {
                if ($tramite->tramite_padre_id) {
                    $padre = Tramite::with(['tramitesHijos' => fn($q) => $q->where('estado', 'derivado')])
                        ->find($tramite->tramite_padre_id);
                    if ($padre && $padre->estado === 'atendido') {
                        $padres = collect([$padre]);
                    }
                } else {
                    $padres = Tramite::where('id', $tramite->id)
                        ->where('estado', 'atendido')
                        ->whereHas('tramitesHijos', fn($q) => $q->where('estado', 'derivado'))
                        ->with(['tramitesHijos' => fn($q) => $q->where('estado', 'derivado')])
                        ->get();
                }
            }
        } else {
            $padres = Tramite::where('estado', 'atendido')
                ->whereHas('tramitesHijos', fn($q) => $q->where('estado', 'derivado'))
                ->with(['tramitesHijos' => fn($q) => $q->where('estado', 'derivado')])
                ->get();
        }

        foreach ($padres as $padre) {
            $hijoDerivado = $padre->tramitesHijos->first();
            if (!$hijoDerivado) continue;

            // Obtener área destino del hijo (desde su seguimiento derivado)
            $segDerivadoHijo = SeguimientoTramite::where('tramite_id', $hijoDerivado->id)
                ->where('accion', 'derivado')
                ->orderBy('created_at', 'desc')
                ->first();

            $areaDestinoId = $segDerivadoHijo?->area_destino_id ?? $hijoDerivado->area_actual_id;

            // Actualizar estado del padre a derivado
            $padre->update(['estado' => 'derivado']);
            $this->line("  Expediente {$padre->numero_expediente}: estado → derivado");

            // Buscar seguimiento "atendido" con descripción de documento derivado
            $segAtendido = SeguimientoTramite::where('tramite_id', $padre->id)
                ->where('accion', 'atendido')
                ->where('descripcion', 'like', '%Documento de respuesta derivado%')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($segAtendido) {
                $segAtendido->update([
                    'accion' => 'derivado',
                    'estado_nuevo' => 'derivado',
                    'area_destino_id' => $areaDestinoId ?? $segAtendido->area_destino_id,
                ]);
                $this->line("    Seguimiento actualizado: accion→derivado, area_destino_id→{$areaDestinoId}");
            } else {
                // Crear nuevo seguimiento derivado si no existe
                $areaOrigen = $segDerivadoHijo?->area_origen_id ?? $padre->area_origen_id;
                SeguimientoTramite::create([
                    'tramite_id' => $padre->id,
                    'usuario_id' => $segDerivadoHijo?->usuario_id,
                    'accion' => 'derivado',
                    'estado_nuevo' => 'derivado',
                    'area_origen_id' => $areaOrigen,
                    'area_destino_id' => $areaDestinoId,
                    'descripcion' => 'Documento de respuesta derivado a ' . ($hijoDerivado->areaActual?->nombre ?? 'otra área') . '. Expediente atendido. (Corregido)',
                    'visible_ciudadano' => true,
                ]);
                $this->line("    Seguimiento derivado creado con area_destino_id→{$areaDestinoId}");
            }

            $corregidos++;
        }

        $this->info("✅ Corregidos {$corregidos} expedientes.");
        return Command::SUCCESS;
    }
}
