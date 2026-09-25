<?php

namespace App\Console\Commands;

use App\Models\Tramite;
use Illuminate\Console\Command;

class ActualizarCodigosVerificacion extends Command
{
    protected $signature = 'tramites:actualizar-codigos';
    protected $description = 'Actualiza los códigos de verificación al nuevo formato (AÑO-ID)';

    public function handle()
    {
        $tramites = Tramite::all();
        $count = 0;

        foreach ($tramites as $tramite) {
            $anio = date('Y', strtotime($tramite->created_at));
            $nuevoCodigo = $anio . '-' . str_pad($tramite->id, 6, '0', STR_PAD_LEFT);
            
            $tramite->codigo_verificacion = $nuevoCodigo;
            $tramite->saveQuietly();
            $count++;
            
            $this->line("Trámite #{$tramite->id}: {$nuevoCodigo}");
        }

        $this->info("✅ Se actualizaron {$count} códigos de verificación.");
        
        return Command::SUCCESS;
    }
}

