<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::beginTransaction();

    // 1. Actualizar Servicio y Página de Legalización (Exterior)
    $textLegalizacion = "Los documentos que requieran certificación de firmas de Notarios miembros de la orden del Colegio de Notarios de Tacna, para su validez en el exterior, deberán contar con la legalización de la firma de éste por parte del Colegio de Notarios de Tacna, además de la certificación del Ministerio de Relaciones Exteriores.(Esta última certificación se realiza directamente en las oficinas del mismo ministerio).\n\nEl costo de la legalización de firma del Notario de Tacna es la suma de S/. 25.00. (trámite en 24 horas) Mayores informes: Teléfono CNT: 052-630739.";
    $htmlLegalizacion = "<h3>Legalización de firmas de los Notarios de Tacna en documentos que van ser remitidos al exterior</h3>" .
                        "<p>Lossssss documentos que requieran certificación de firmas de Notarios miembros de la orden del Colegio de Notarios de Tacna, para su validez en el exterior, deberán contar con la legalización de la firma de éste por parte del Colegio de Notarios de Tacna, además de la certificación del Ministerio de Relaciones Exteriores. (Esta última certificación se realiza directamente en las oficinas del mismo ministerio).</p>" .
                        "<p><strong>El costo de la legalización de firma del Notario de Tacna es la suma de S/. 25.00. (trámite en 24 horas)</strong></p>" .
                        "<p>Mayores informes: Teléfono CNT: 052-630739.</p>";

    DB::table('gc_servicios')->where('id', 1)->update([
        'nombre' => 'Legalización de firmas (Exterior)',
        'descripcion' => $textLegalizacion,
        'precio' => 25.00
    ]);

    DB::table('gc_paginas')->where('slug', 'tramites-notariales')->update([
        'contenido' => $htmlLegalizacion,
        'descripcion' => 'Información sobre legalización de firmas para el exterior'
    ]);

    // 2. Actualizar Servicio y Página de Capacitación
    $textCapacitacion = "En el marco de actualizar conocimientos y mejorar nuestra atención al público usuario con nuestros servicios notariales. Se han desarrollado los siguientes temas en diversos años: Kursos, Diplomados y Seminarios de actualización.";
    $htmlCapacitacion = "<h3>Capacitación permanente a los miembros de la orden y sus colaboradores</h3>" .
                        "<p>En el marco de actualizar conocimientos y mejorar nuestra atención al público usuario con nuestros servicios notariales. Se han desarrollado los siguientes temas en diversos años:</p>" .
                        "<ul>" .
                        "<li>Curso organizado en forma conjunta con la Superintendencia de Banca, Seguros y AFPs-Unidad e Inteligencia Financiera, denominado “Implementación del Sistema de Prevención de Lavado de Activos y Financiamiento del Terrorismo, Generación, Llenado y Envío del Registro de Operaciones para los Notarios”, realizado el 24 octubre del 2014.</li>" .
                        "<li>En Convenio con el Instituto Agora, se llevó a cabo el “Diplomado de Especialización en Criminalidad Organizada”, dictado el día 08 de diciembre del 2014.</li>" .
                        "<li>Diplomado organizado en forma conjunta con el Círculo de Estudios Jurídicos IUS NOVA y la Universidad Privada de Tacna, denominado “Diplomado de Especialización en Responsabilidad Civil”, llevado a cabo el 11 y 18 Julio y el 08,15 y 22 Agosto del 2015.</li>" .
                        "<li>Diplomado organizado en forma conjunta con el Círculo de Estudios Jurídicos IUS NOVA y la Universidad Privada de Tacna, denominado “Diplomado de Especialización en Derecho Civil Patrimonial” llevado a cabo del 20 de agosto al 19 de noviembre del 2016.</li>" .
                        "<li>Seminarios denominados “Cursos de Actualización en materia de Prevención de Lavado de Activos” y la “Función Notarial de acuerdo al Decreto Legislativo N° 1246”, ambos llevados a cabo el día 29 de Diciembre del 2016.</li>" .
                        "</ul>";

    DB::table('gc_servicios')->where('id', 2)->update([
        'nombre' => 'Capacitación Permanente',
        'descripcion' => $textCapacitacion
    ]);

    DB::table('gc_paginas')->where('slug', 'servicios-administrativos')->update([
        'contenido' => $htmlCapacitacion,
        'descripcion' => 'Capacitación y formación constante para notarios y colaboradores'
    ]);

    // 3. Renombrar los menús para que coincidan con la nueva imagen profesional
    DB::table('gc_menus')->where('id', 14)->update(['nombre' => 'Legalización de Firmas (Exterior)']);
    DB::table('gc_menus')->where('id', 17)->update(['nombre' => 'Capacitación Permanente']);

    DB::commit();
    echo "Actualización completada exitosamente.";
} catch (\Exception $e) {
    DB::rollBack();
    echo "Error: " . $e->getMessage();
}
