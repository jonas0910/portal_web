<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('gc_servicios', 'url')) {
    Schema::table('gc_servicios', function (Blueprint $table) {
        $table->string('url')->nullable()->after('orden');
    });
    echo "Columna 'url' añadida exitosamente a 'gc_servicios'.\n";
} else {
    echo "La columna 'url' ya existe.\n";
}
