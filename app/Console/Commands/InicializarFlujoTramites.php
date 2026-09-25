<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tramite;

class InicializarFlujoTramites extends Command
{
    protected $signature = 'tramites:inicializar-flujo';
    protected $description = 'Inicializa los campos de flujo de trabajo para trámites existentes';

    public function handle()
    {
        $this->info('Inicializando flujo de trabajo para trámites existentes...');

        // Trámites que ya están en proceso o atendidos: marcar como ya recibidos
        $tramitesEnProceso = Tramite::whereIn('estado', ['en_proceso', 'atendido', 'archivado'])
            ->whereNull('recibido_at')
            ->get();

        foreach ($tramitesEnProceso as $tramite) {
            $tramite->update([
                'recibido_at' => $tramite->created_at,
                'recibido_por_id' => $tramite->usuario_asignado_id,
                'pendiente_recepcion' => false,
            ]);
            $this->line("Trámite #{$tramite->id}: Marcado como recibido");
        }

        // Trámites pendientes o derivados: marcar como pendiente de recepción
        $tramitesPendientes = Tramite::whereIn('estado', ['pendiente', 'derivado', 'observado'])
            ->get();

        foreach ($tramitesPendientes as $tramite) {
            $tramite->update([
                'pendiente_recepcion' => true,
                'recibido_at' => null,
                'recibido_por_id' => null,
            ]);
            $this->line("Trámite #{$tramite->id}: Pendiente de recepción");
        }

        $this->info('✅ Flujo de trabajo inicializado correctamente.');
        $this->info('   - ' . $tramitesEnProceso->count() . ' trámites marcados como recibidos');
        $this->info('   - ' . $tramitesPendientes->count() . ' trámites pendientes de recepción');

        return Command::SUCCESS;
    }
}
