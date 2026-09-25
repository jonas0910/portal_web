<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tramite;
use App\Models\SeguimientoTramite;
use App\Models\DocumentoTramite;
use App\Models\CopiaTramite;
use Illuminate\Support\Facades\DB;

class DejarSoloUltimosExpedientes extends Command
{
    protected $signature = 'tramites:dejar-solo-ultimos {cantidad=7} {--force : Sin preguntar confirmación}';
    protected $description = 'Elimina todos los expedientes excepto los N más recientes (default: 7).';

    public function handle()
    {
        $cantidad = (int) $this->argument('cantidad');
        if ($cantidad < 1) {
            $this->error('La cantidad debe ser al menos 1.');
            return 1;
        }

        $idsMantener = Tramite::orderBy('created_at', 'desc')->limit($cantidad)->pluck('id')->toArray();
        $total = Tramite::count();
        $aEliminar = $total - count($idsMantener);

        if ($aEliminar <= 0) {
            $this->info("Hay {$total} expedientes. No se elimina ninguno (ya son los últimos).");
            return 0;
        }

        if (!$this->option('force') && !$this->confirm("Se eliminarán {$aEliminar} expedientes y se mantendrán los últimos {$cantidad}. ¿Continuar?")) {
            return 0;
        }

        DB::beginTransaction();
        try {
            $idsEliminar = Tramite::whereNotIn('id', $idsMantener)->pluck('id')->toArray();

            SeguimientoTramite::whereIn('tramite_id', $idsEliminar)->delete();
            DocumentoTramite::whereIn('tramite_id', $idsEliminar)->delete();
            CopiaTramite::whereIn('tramite_id', $idsEliminar)->delete();
            Tramite::whereIn('id', $idsEliminar)->forceDelete();

            DB::commit();
            $this->info("✓ Eliminados {$aEliminar} expedientes. Quedan los últimos {$cantidad}.");
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
