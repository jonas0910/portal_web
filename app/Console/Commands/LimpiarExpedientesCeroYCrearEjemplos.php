<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tramite;
use App\Models\TipoTramite;
use App\Models\AreaTramite;
use App\Models\SeguimientoTramite;
use App\Models\DocumentoTramite;
use App\Models\CopiaTramite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LimpiarExpedientesCeroYCrearEjemplos extends Command
{
    protected $signature = 'tramites:limpiar-cero-y-ejemplos';
    protected $description = 'Elimina expedientes en cero y crea 7 ejemplos (trámites web e internos con derivación). Sin wipe.';

    public function handle()
    {
        $this->info('Ejecutando: eliminar expedientes en cero y crear 7 ejemplos...');

        DB::beginTransaction();
        try {
            // 1. Eliminar expedientes "en cero": numero_expediente nulo, vacío, "0" o correlativo 0
            $queryCero = Tramite::query()
                ->where(function ($q) {
                    $q->whereNull('numero_expediente')
                        ->orWhere('numero_expediente', '')
                        ->orWhere('numero_expediente', '0')
                        ->orWhere('correlativo', 0);
                });
            $idsCero = $queryCero->pluck('id')->toArray();
            $cantEliminados = count($idsCero);

            if ($cantEliminados > 0) {
                SeguimientoTramite::whereIn('tramite_id', $idsCero)->delete();
                DocumentoTramite::whereIn('tramite_id', $idsCero)->delete();
                CopiaTramite::whereIn('tramite_id', $idsCero)->delete();
                Tramite::whereIn('id', $idsCero)->forceDelete();
                $this->info("✓ Eliminados {$cantEliminados} expedientes en cero.");
            } else {
                $this->line('  No había expedientes en cero.');
            }

            // 2. Crear 7 ejemplos: trámites web + internos con derivación
            $mesaPartes = AreaTramite::mesaDePartes() ?? AreaTramite::where('codigo', 'MESA-PARTES')->first();
            if (!$mesaPartes) {
                $mesaPartes = AreaTramite::first();
            }
            $areas = AreaTramite::where('activo', true)->orderBy('orden')->get();
            $tipoTramite = TipoTramite::where('activo', true)->first();

            if (!$mesaPartes || $areas->isEmpty() || !$tipoTramite) {
                $this->error('Faltan áreas o tipos de trámite. Ejecute TramiteSeeder.');
                DB::rollBack();
                return 1;
            }

            $creados = 0;

            // --- 4 trámites WEB (pendiente en Mesa de Partes) ---
            $webEjemplos = [
                ['nombres' => 'Rosa María', 'apellidos' => 'Vargas López', 'email' => 'rosa.vargas@email.com', 'celular' => '987111222', 'asunto' => 'Solicitud de licencia de funcionamiento para bodega'],
                ['nombres' => 'José Luis', 'apellidos' => 'Quispe Flores', 'email' => 'jose.quispe@email.com', 'celular' => '987222333', 'asunto' => 'Solicito constancia de no adeudo para trámite notarial'],
                ['nombres' => 'Carmen', 'apellidos' => 'Díaz Soto', 'email' => 'carmen.diaz@email.com', 'celular' => '987333444', 'asunto' => 'Copia certificada de partida de nacimiento'],
                ['nombres' => 'Pedro', 'apellidos' => 'Mendoza Rojas', 'email' => 'pedro.mendoza@email.com', 'celular' => '987444555', 'asunto' => 'Solicitud de fraccionamiento de deuda tributaria'],
            ];
            foreach ($webEjemplos as $datos) {
                $this->crearTramiteWeb($mesaPartes, $tipoTramite, $datos);
                $creados++;
            }

            // --- 3 trámites INTERNOS con derivación (origen interno, derivados a otra área) ---
            $areasParaDerivar = $areas->where('id', '!=', $mesaPartes->id)->values();
            if ($areasParaDerivar->isEmpty()) {
                $areasParaDerivar = $areas;
            }
            $internoEjemplos = [
                ['asunto' => 'Memorándum N° 012-2026-GDU - Informe técnico de habilitación urbana'],
                ['asunto' => 'Oficio N° 045-2026-GAT - Consulta sobre devolución de tributos'],
                ['asunto' => 'Informe N° 008-2026-GDE - Evaluación de licencia de funcionamiento'],
            ];
            foreach ($internoEjemplos as $i => $datos) {
                $areaOrigen = $areasParaDerivar->get($i % $areasParaDerivar->count());
                $areaDestino = $areasParaDerivar->get(($i + 1) % $areasParaDerivar->count());
                if ($areaDestino->id === $areaOrigen->id) {
                    $areaDestino = $areasParaDerivar->get(($i + 2) % $areasParaDerivar->count()) ?? $areaOrigen;
                }
                $this->crearTramiteInternoConDerivacion($areaOrigen, $areaDestino, $tipoTramite, $datos['asunto']);
                $creados++;
            }

            DB::commit();
            $this->info("✓ Creados {$creados} trámites de ejemplo (4 web + 3 internos con derivación).");
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }

    private function crearTramiteWeb(AreaTramite $mesaPartes, TipoTramite $tipo, array $datos): void
    {
        $exp = Tramite::generarNumeroExpediente();
        $tramite = Tramite::create([
            'numero_expediente' => $exp['numero_expediente'],
            'anio' => $exp['anio'],
            'correlativo' => $exp['correlativo'],
            'tipo_tramite_id' => $tipo->id,
            'tipo_documento' => 'DNI',
            'numero_documento' => '7' . rand(1000000, 9999999),
            'nombres' => $datos['nombres'],
            'apellidos' => $datos['apellidos'],
            'email' => $datos['email'],
            'celular' => $datos['celular'],
            'direccion' => 'Jr. Ejemplo 100, Distrito',
            'tipo_documento_externo' => 'SOLICITUD',
            'numero_documento_externo' => '001-' . date('Y'),
            'fecha_documento_externo' => now(),
            'asunto' => $datos['asunto'],
            'descripcion' => 'Solicito la atención de mi trámite. (Ingresado por Portal Web)',
            'folios' => rand(1, 5),
            'estado' => 'pendiente',
            'prioridad' => 'normal',
            'origen' => 'web',
            'area_actual_id' => $mesaPartes->id,
            'area_origen_id' => $mesaPartes->id,
            'fecha_ingreso' => now(),
            'fecha_limite' => now()->addDays($tipo->plazo_dias ?? 15),
            'pendiente_recepcion' => true,
        ]);
        SeguimientoTramite::create([
            'tramite_id' => $tramite->id,
            'accion' => 'creado',
            'descripcion' => 'Trámite ingresado a través del Portal Web Municipal',
            'estado_nuevo' => 'pendiente',
            'visible_ciudadano' => true,
        ]);
        $this->line("  [Web] {$tramite->numero_expediente} | {$datos['asunto']}");
    }

    private function crearTramiteInternoConDerivacion(AreaTramite $areaOrigen, AreaTramite $areaDestino, TipoTramite $tipo, string $asunto): void
    {
        $exp = Tramite::generarNumeroExpediente();
        $tramite = Tramite::create([
            'numero_expediente' => $exp['numero_expediente'],
            'anio' => $exp['anio'],
            'correlativo' => $exp['correlativo'],
            'tipo_tramite_id' => $tipo->id,
            'tipo_documento' => 'INTERNO',
            'numero_documento' => 'N/A',
            'nombres' => 'Área',
            'apellidos' => $areaOrigen->nombre,
            'email' => 'interno@municipalidad.gob.pe',
            'tipo_documento_generado' => 'MEMO',
            'numero_documento_generado' => 'MEM-' . $exp['numero_expediente'],
            'asunto' => $asunto,
            'descripcion' => 'Documento interno para conocimiento y/o respuesta.',
            'estado' => 'derivado',
            'prioridad' => 'normal',
            'origen' => 'interno',
            'area_origen_id' => $areaOrigen->id,
            'area_anterior_id' => $areaOrigen->id,
            'area_actual_id' => $areaDestino->id,
            'fecha_ingreso' => Carbon::now()->subDays(rand(1, 5)),
            'fecha_limite' => Carbon::now()->addDays($tipo->plazo_dias ?? 15),
            'pendiente_recepcion' => true,
            'ultimo_movimiento_at' => now(),
        ]);
        SeguimientoTramite::create([
            'tramite_id' => $tramite->id,
            'accion' => 'creado',
            'descripcion' => 'Documento interno registrado por ' . ($areaOrigen->nombre ?? 'área de origen'),
            'estado_nuevo' => 'registrado',
            'area_origen_id' => $areaOrigen->id,
            'visible_ciudadano' => false,
        ]);
        SeguimientoTramite::create([
            'tramite_id' => $tramite->id,
            'accion' => 'derivado',
            'descripcion' => 'Derivado a ' . $areaDestino->nombre . '. Pendiente de recepción.',
            'estado_anterior' => 'en_proceso',
            'estado_nuevo' => 'derivado',
            'area_origen_id' => $areaOrigen->id,
            'area_destino_id' => $areaDestino->id,
            'visible_ciudadano' => true,
        ]);
        $this->line("  [Interno] {$tramite->numero_expediente} | {$areaOrigen->nombre} → {$areaDestino->nombre} | " . Str::limit($asunto, 50));
    }
}
