<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tramite;
use App\Models\TipoTramite;
use App\Models\AreaTramite;
use App\Models\SeguimientoTramite;
use Illuminate\Support\Facades\DB;

class CrearTramiteWebEjemplo extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tramite:crear-ejemplo-web 
                            {--tipo= : Código del tipo de trámite (ej: LIC-FUNC)}
                            {--dni= : DNI del solicitante}
                            {--nombre= : Nombres del solicitante}
                            {--apellido= : Apellidos del solicitante}';

    /**
     * The console command description.
     */
    protected $description = 'Crea un trámite externo de ejemplo como si fuera ingresado desde el portal web';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('╔══════════════════════════════════════════════════════════════╗');
        $this->info('║  📋 CREAR TRÁMITE EXTERNO - SIMULACIÓN PORTAL WEB           ║');
        $this->info('╚══════════════════════════════════════════════════════════════╝');
        $this->newLine();

        // Obtener tipo de trámite
        $tiposCodigo = TipoTramite::where('activo', true)->pluck('nombre', 'codigo')->toArray();
        
        if (empty($tiposCodigo)) {
            $this->error('No hay tipos de trámite disponibles. Ejecute primero: php artisan db:seed --class=TramiteSeeder');
            return 1;
        }

        $this->info('📌 Tipos de trámite disponibles:');
        foreach ($tiposCodigo as $codigo => $nombre) {
            $this->line("   - <fg=cyan>{$codigo}</>: {$nombre}");
        }
        $this->newLine();

        // Seleccionar tipo o usar el proporcionado
        $codigoTipo = $this->option('tipo');
        if (!$codigoTipo || !isset($tiposCodigo[$codigoTipo])) {
            $codigoTipo = $this->choice(
                '¿Qué tipo de trámite desea crear?',
                array_keys($tiposCodigo),
                array_search('LIC-FUNC', array_keys($tiposCodigo)) ?: 0
            );
        }

        $tipoTramite = TipoTramite::where('codigo', $codigoTipo)->first();
        
        if (!$tipoTramite) {
            $this->error("Tipo de trámite no encontrado: {$codigoTipo}");
            return 1;
        }

        $this->info("✅ Tipo seleccionado: <fg=green>{$tipoTramite->nombre}</>");
        $this->newLine();

        // Datos del ciudadano (simulados o proporcionados)
        $datosEjemplo = $this->obtenerDatosCiudadano();
        
        $this->info('👤 Datos del ciudadano:');
        $this->table(
            ['Campo', 'Valor'],
            [
                ['Tipo Doc.', $datosEjemplo['tipo_documento']],
                ['Nº Documento', $datosEjemplo['numero_documento']],
                ['Nombres', $datosEjemplo['nombres']],
                ['Apellidos', $datosEjemplo['apellidos']],
                ['Email', $datosEjemplo['email']],
                ['Celular', $datosEjemplo['celular']],
                ['Dirección', $datosEjemplo['direccion']],
            ]
        );

        // Asunto según tipo de trámite
        $asuntos = $this->getAsuntosPorTipo($codigoTipo);
        $asunto = $asuntos[array_rand($asuntos)];

        $this->info("📝 Asunto: <fg=yellow>{$asunto}</>");
        $this->newLine();

        if (!$this->confirm('¿Desea crear el trámite con estos datos?', true)) {
            $this->warn('Operación cancelada.');
            return 0;
        }

        // Crear el trámite
        try {
            DB::beginTransaction();

            // Obtener Mesa de Partes (documentos externos siempre van a Mesa de Partes primero)
            $mesaPartes = AreaTramite::mesaDePartes();
            if (!$mesaPartes) {
                $mesaPartes = AreaTramite::where('codigo', 'MESA-PARTES')->first();
            }

            if (!$mesaPartes) {
                $this->error('No hay Mesa de Partes configurada. Ejecute: php artisan db:seed --class=TramiteSeeder');
                return 1;
            }

                // Generar datos del documento externo
            $tiposDocExt = ['SOLICITUD', 'CARTA', 'FUT', 'OFICIO'];
            $tipoDocExt = $tiposDocExt[array_rand($tiposDocExt)];
            $numeroDocExt = sprintf('%03d-%d', rand(1, 999), date('Y'));

            $this->info("📬 Área destino: <fg=cyan>{$mesaPartes->nombre}</> (documento externo)");
            $this->info("📄 Documento: <fg=yellow>{$tipoDocExt} N° {$numeroDocExt}</>");

            // Generar número de expediente
            $expediente = Tramite::generarNumeroExpediente();

            $tramite = Tramite::create([
                'numero_expediente' => $expediente['numero_expediente'],
                'anio' => $expediente['anio'],
                'correlativo' => $expediente['correlativo'],
                'tipo_tramite_id' => $tipoTramite->id,
                // Datos del solicitante
                'tipo_documento' => $datosEjemplo['tipo_documento'],
                'numero_documento' => $datosEjemplo['numero_documento'],
                'nombres' => $datosEjemplo['nombres'],
                'apellidos' => $datosEjemplo['apellidos'],
                'razon_social' => $datosEjemplo['razon_social'] ?? null,
                'ruc' => $datosEjemplo['ruc'] ?? null,
                'email' => $datosEjemplo['email'],
                'telefono' => $datosEjemplo['telefono'] ?? null,
                'celular' => $datosEjemplo['celular'],
                'direccion' => $datosEjemplo['direccion'],
                // Documento externo que sustenta el trámite
                'tipo_documento_externo' => $tipoDocExt,
                'numero_documento_externo' => $numeroDocExt,
                'fecha_documento_externo' => now(),
                // Detalle del trámite
                'asunto' => $asunto,
                'descripcion' => 'Solicito la atención de mi trámite. Quedo atento a su respuesta. (Trámite registrado desde el Portal Web Municipal)',
                'folios' => rand(1, 5),
                'estado' => 'pendiente',
                'prioridad' => 'normal',
                'origen' => 'web', // ⚡ ORIGEN WEB - Trámite externo
                'area_actual_id' => $mesaPartes->id, // ⚡ Documento externo va a Mesa de Partes
                'fecha_ingreso' => now(),
                'fecha_limite' => now()->addDays($tipoTramite->plazo_dias),
                'pendiente_recepcion' => true,
            ]);

            // Registrar seguimiento inicial
            SeguimientoTramite::create([
                'tramite_id' => $tramite->id,
                'accion' => 'creado',
                'descripcion' => 'Trámite ingresado a través del Portal Web Municipal',
                'estado_nuevo' => 'pendiente',
                'visible_ciudadano' => true,
            ]);

            DB::commit();

            $this->newLine();
            $this->info('╔══════════════════════════════════════════════════════════════╗');
            $this->info('║  ✅ TRÁMITE CREADO EXITOSAMENTE                              ║');
            $this->info('╚══════════════════════════════════════════════════════════════╝');
            $this->newLine();

            $this->table(
                ['Información', 'Valor'],
                [
                    ['Nº Expediente', $tramite->numero_expediente],
                    ['Código Verificación', $tramite->codigo_verificacion],
                    ['Documento Externo', $tipoDocExt . ' N° ' . $numeroDocExt],
                    ['Fecha Documento', now()->format('d/m/Y')],
                    ['Tipo de Trámite', $tipoTramite->nombre],
                    ['Área Destino', $mesaPartes->nombre . ' (documento externo)'],
                    ['Área Final', $tipoTramite->area?->nombre ?? 'Por derivar'],
                    ['Estado', 'Pendiente de Recepción'],
                    ['Origen', '🌐 Portal Web (externo)'],
                    ['Fecha Ingreso', $tramite->fecha_ingreso->format('d/m/Y H:i')],
                    ['Fecha Límite', $tramite->fecha_limite->format('d/m/Y')],
                ]
            );

            $this->newLine();
            $this->info('📋 El ciudadano puede consultar su trámite en:');
            $this->line('   <fg=cyan>http://localhost:9000/tramites/consulta</>');
            $this->line("   Usando: Nº Expediente = <fg=green>{$tramite->numero_expediente}</>");
            $this->line("           Código = <fg=green>{$tramite->codigo_verificacion}</>");
            $this->newLine();

            $this->info('👨‍💼 El funcionario puede ver el trámite en:');
            $this->line('   <fg=cyan>http://localhost:9000/admin/tramites</>');
            $this->line('   Sección: Documentos Recibidos (pendientes de recepcionar)');
            $this->newLine();

            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error al crear el trámite: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Obtener datos del ciudadano de ejemplo
     */
    private function obtenerDatosCiudadano(): array
    {
        $ejemplos = [
            [
                'tipo_documento' => 'DNI',
                'numero_documento' => '76543210',
                'nombres' => 'Rosa María',
                'apellidos' => 'Vásquez Huamán',
                'email' => 'rosa.vasquez@gmail.com',
                'celular' => '987123456',
                'direccion' => 'Jr. Los Rosales 245, Urb. Santa Elena',
            ],
            [
                'tipo_documento' => 'DNI',
                'numero_documento' => '43215678',
                'nombres' => 'Jorge Luis',
                'apellidos' => 'Mendoza Quispe',
                'email' => 'jmendoza@hotmail.com',
                'celular' => '956789012',
                'direccion' => 'Av. Las Palmeras 890, Centro',
            ],
            [
                'tipo_documento' => 'DNI',
                'numero_documento' => '87654321',
                'nombres' => 'Carmen Elena',
                'apellidos' => 'Soto Paredes',
                'email' => 'carmen.soto@outlook.com',
                'celular' => '912345678',
                'direccion' => 'Calle Las Orquídeas 567, Urb. Primavera',
            ],
            [
                'tipo_documento' => 'RUC',
                'numero_documento' => '20556677889',
                'nombres' => 'Pedro Antonio',
                'apellidos' => 'Ramos García',
                'razon_social' => 'Comercial Los Andes S.A.C.',
                'ruc' => '20556677889',
                'email' => 'contacto@comercialandes.pe',
                'telefono' => '01-5678901',
                'celular' => '998877665',
                'direccion' => 'Av. Comercio 1234, Zona Industrial',
            ],
        ];

        // Usar DNI proporcionado o aleatorio
        $dni = $this->option('dni');
        $nombre = $this->option('nombre');
        $apellido = $this->option('apellido');
        
        if ($dni && $nombre && $apellido) {
            return [
                'tipo_documento' => 'DNI',
                'numero_documento' => $dni,
                'nombres' => $nombre,
                'apellidos' => $apellido,
                'email' => strtolower(str_replace(' ', '.', $nombre)) . '@example.com',
                'celular' => '9' . rand(10000000, 99999999),
                'direccion' => 'Dirección proporcionada por el usuario',
            ];
        }

        return $ejemplos[array_rand($ejemplos)];
    }

    /**
     * Obtener asuntos de ejemplo según el tipo de trámite
     */
    private function getAsuntosPorTipo(string $codigo): array
    {
        $asuntos = [
            'LIC-CONST' => [
                'Solicito licencia de construcción para vivienda unifamiliar de 2 pisos',
                'Licencia para ampliación de segundo nivel en mi propiedad',
                'Solicitud de autorización para remodelación de fachada',
            ],
            'LIC-FUNC' => [
                'Solicito licencia de funcionamiento para minimarket',
                'Licencia de funcionamiento para peluquería y spa',
                'Autorización para apertura de cafetería con atención al público',
                'Licencia para consultorio dental',
            ],
            'CERT-DEFCIV' => [
                'Certificado de seguridad en defensa civil para local comercial',
                'Inspección técnica de seguridad para restaurante',
            ],
            'PART-NAC' => [
                'Solicito copia certificada de partida de nacimiento',
                'Partida de nacimiento para trámite de pasaporte',
            ],
            'PART-MAT' => [
                'Copia certificada de partida de matrimonio civil',
            ],
            'FRACC-DEUDA' => [
                'Solicito fraccionamiento de deuda de impuesto predial años 2023-2024',
                'Plan de pagos para regularizar arbitrios municipales',
            ],
            'CONST-NODEUDO' => [
                'Constancia de no adeudo para venta de inmueble',
                'Certificado de no deuda tributaria',
            ],
            'DOC-EXT' => [
                'Solicitud de información sobre procedimiento de licencia',
                'Reclamo por falta de recojo de residuos sólidos',
                'Solicitud de poda de árbol frente a mi domicilio',
                'Queja por ruidos molestos de local vecino',
            ],
            'AUT-PUB' => [
                'Permiso para colocación de letrero publicitario en fachada',
            ],
            'CERT-NUM' => [
                'Asignación de número de predio para lote nuevo',
            ],
        ];

        return $asuntos[$codigo] ?? ['Solicitud de trámite municipal'];
    }
}
