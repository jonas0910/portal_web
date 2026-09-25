<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tramite;
use App\Models\TipoTramite;
use App\Models\AreaTramite;
use App\Models\SeguimientoTramite;
use Illuminate\Support\Facades\DB;

class CrearTramitesWebEjemplos extends Command
{
    protected $signature = 'tramites:crear-ejemplos-web {cantidad=3}';
    protected $description = 'Crea N trámites de ejemplo como si fueran ingresados desde el portal web (default: 3)';

    public function handle()
    {
        $cantidad = (int) $this->argument('cantidad');
        if ($cantidad < 1 || $cantidad > 10) {
            $this->error('La cantidad debe ser entre 1 y 10.');
            return 1;
        }

        $mesaPartes = AreaTramite::mesaDePartes() ?? AreaTramite::where('codigo', 'MESA-PARTES')->first();
        if (!$mesaPartes) {
            $mesaPartes = AreaTramite::first();
        }
        if (!$mesaPartes) {
            $this->error('No hay áreas configuradas. Ejecute las migraciones y seeders.');
            return 1;
        }

        $tipoTramite = TipoTramite::where('activo', true)->first();
        if (!$tipoTramite) {
            $this->error('No hay tipos de trámite activos.');
            return 1;
        }

        $ejemplos = [
            [
                'tipo_documento' => 'DNI',
                'numero_documento' => '45678912',
                'nombres' => 'Ana Lucía',
                'apellidos' => 'Torres Vega',
                'email' => 'ana.torres@gmail.com',
                'celular' => '987654321',
                'direccion' => 'Jr. Los Olivos 123, Urb. San Carlos',
                'tipo_doc_ext' => 'SOLICITUD',
                'numero_doc_ext' => '001-2026',
                'asunto' => 'Solicito licencia de funcionamiento para panadería artesanal',
            ],
            [
                'tipo_documento' => 'DNI',
                'numero_documento' => '52345678',
                'nombres' => 'Carlos Enrique',
                'apellidos' => 'Rojas Díaz',
                'email' => 'carlos.rojas@hotmail.com',
                'celular' => '956123789',
                'direccion' => 'Av. San Martín 456, Centro',
                'tipo_doc_ext' => 'CARTA',
                'numero_doc_ext' => '045-2026',
                'asunto' => 'Solicito constancia de no adeudo para venta de inmueble',
            ],
            [
                'tipo_documento' => 'DNI',
                'numero_documento' => '67891234',
                'nombres' => 'María Fernanda',
                'apellidos' => 'Gómez López',
                'email' => 'maria.gomez@outlook.com',
                'celular' => '912345678',
                'direccion' => 'Calle Las Flores 789, Urb. Primavera',
                'tipo_doc_ext' => 'FUT',
                'numero_doc_ext' => '078-2026',
                'asunto' => 'Solicito copia certificada de partida de nacimiento',
            ],
        ];

        DB::beginTransaction();
        try {
            for ($i = 0; $i < $cantidad; $i++) {
                $datos = $ejemplos[$i % count($ejemplos)];
                $expediente = Tramite::generarNumeroExpediente();

                $tramite = Tramite::create([
                    'numero_expediente' => $expediente['numero_expediente'],
                    'anio' => $expediente['anio'],
                    'correlativo' => $expediente['correlativo'],
                    'tipo_tramite_id' => $tipoTramite->id,
                    'tipo_documento' => $datos['tipo_documento'],
                    'numero_documento' => $datos['numero_documento'],
                    'nombres' => $datos['nombres'],
                    'apellidos' => $datos['apellidos'],
                    'email' => $datos['email'],
                    'celular' => $datos['celular'],
                    'direccion' => $datos['direccion'],
                    'tipo_documento_externo' => $datos['tipo_doc_ext'],
                    'numero_documento_externo' => $datos['numero_doc_ext'],
                    'fecha_documento_externo' => now(),
                    'asunto' => $datos['asunto'],
                    'descripcion' => 'Solicito la atención de mi trámite. Quedo atento a su respuesta. (Trámite registrado desde el Portal Web Municipal)',
                    'folios' => rand(1, 5),
                    'estado' => 'pendiente',
                    'prioridad' => 'normal',
                    'origen' => 'web',
                    'area_actual_id' => $mesaPartes->id,
                    'area_origen_id' => $mesaPartes->id,
                    'fecha_ingreso' => now(),
                    'fecha_limite' => now()->addDays($tipoTramite->plazo_dias ?? 15),
                    'pendiente_recepcion' => true,
                ]);

                SeguimientoTramite::create([
                    'tramite_id' => $tramite->id,
                    'accion' => 'creado',
                    'descripcion' => 'Trámite ingresado a través del Portal Web Municipal',
                    'estado_nuevo' => 'pendiente',
                    'visible_ciudadano' => true,
                ]);

                $this->line("  {$tramite->numero_expediente} | {$datos['nombres']} {$datos['apellidos']} | {$datos['asunto']}");
            }

            DB::commit();
            $this->info("✅ Creados {$cantidad} trámites generados por web.");
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
