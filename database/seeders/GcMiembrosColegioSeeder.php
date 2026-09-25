<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GcMiembrosColegioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. NOTARIOS (Directorio actual)
        $notarios = [
            ['nombre' => 'DR. VICENTE GUIDO', 'apellidos' => 'QUISPE CHATA', 'notaria' => 'V. Quispe Chata', 'direccion' => 'Calle Hipólito Unanue N° 336', 'distrito' => 'Cercado', 'telefono' => '052-630739'],
            ['nombre' => 'DRA. ROSA MARÍA', 'apellidos' => 'MÁLAGA CUTIPÉ', 'notaria' => 'Rosa M. Málaga', 'direccion' => 'Calle Bolívar 201', 'distrito' => 'Cercado', 'telefono' => '052-421447'],
            ['nombre' => 'DRA. ÁNGELA MARÍA', 'apellidos' => 'DÍAZ JARA ALMONTE', 'notaria' => 'Ángela Díaz', 'direccion' => 'Calle Deustua 444', 'distrito' => 'Cercado', 'telefono' => '052-246580'],
            ['nombre' => 'DRA. ROSARIO CATHERINE', 'apellidos' => 'BOHÓRQUEZ VEGA', 'notaria' => 'R. Bohórquez', 'direccion' => 'Av. Pinto 1205', 'distrito' => 'Alto de la Alianza', 'telefono' => '052-315848'],
            ['nombre' => 'DRA. PRESCILA', 'apellidos' => 'MÉNDEZ PAYEHUANCA', 'notaria' => 'Prescila Méndez', 'direccion' => 'Urb. Tacna A-29 (Av. Celestino Vargas)', 'distrito' => 'Pocollay', 'telefono' => '052-402121'],
            ['nombre' => 'DRA. ELBA AURORA ANGUIS SAYERS', 'apellidos' => 'DE ADAWI', 'notaria' => 'Elba Anguis', 'direccion' => 'Calle San Martín 1005', 'distrito' => 'Cercado', 'telefono' => '052-243171'],
            ['nombre' => 'DR. OSCAR ABEL', 'apellidos' => 'CAPARACHÍN RIVERA', 'notaria' => 'Oscar Caparachín', 'direccion' => 'Av. Juan Moore 1400', 'distrito' => 'Ciudad Nueva', 'telefono' => '052-601001'],
            ['nombre' => 'DR. KARIM ISRAEL', 'apellidos' => 'SARABIA PALZA', 'notaria' => 'Karim Sarabia', 'direccion' => 'Av. La Cultura S/N', 'distrito' => 'Gregorio Albarracín', 'telefono' => '052-401140'],
            ['nombre' => 'DR. VÍCTOR EDILBERTO', 'apellidos' => 'LOZANO VALDERRAMA', 'notaria' => 'Víctor Lozano', 'direccion' => 'Calle Callao 147', 'distrito' => 'Cercado', 'telefono' => '052-422744'],
            ['nombre' => 'DR. EDGAR', 'apellidos' => 'PINEDA GAMARRA', 'notaria' => 'Edgar Pineda', 'direccion' => 'Calle Julio MacLean N° 328', 'distrito' => 'Cercado', 'telefono' => '052-600001'],
        ];

        foreach ($notarios as $idx => $n) {
            \App\Models\MiembroColegio::create(array_merge($n, [
                'tipo' => 'notario',
                'orden' => $idx + 1,
            ]));
        }

        // 2. JUNTA DIRECTIVA (Gestión 2024-2025 - Ejemplo)
        $junta = [
            ['cargo' => 'Decano', 'nombre' => 'DR. EDGAR PINEDA GAMARRA', 'periodo' => '2024-2025', 'orden' => 1],
            ['cargo' => 'Vicedecano', 'nombre' => 'DR. OSCAR ABEL CAPARACHÍN RIVERA', 'periodo' => '2024-2025', 'orden' => 2],
            ['cargo' => 'Secretario', 'nombre' => 'DRA. ROSA MARÍA MÁLAGA CUTIPÉ', 'periodo' => '2024-2025', 'orden' => 3],
            ['cargo' => 'Tesorero', 'nombre' => 'DR. KARIM ISRAEL SARABIA PALZA', 'periodo' => '2024-2025', 'orden' => 4],
        ];

        foreach ($junta as $j) {
            \App\Models\MiembroColegio::create(array_merge($j, [
                'tipo' => 'junta_directiva',
            ]));
        }

        // 3. TRIBUNAL DE HONOR
        $tribunal = [
            ['cargo' => 'Presidente', 'nombre' => 'DR. VICENTE GUIDO QUISPE CHATA', 'periodo' => '2024-2025', 'orden' => 1],
            ['cargo' => 'Vocal', 'nombre' => 'DRA. ÁNGELA MARÍA DÍAZ JARA ALMONTE', 'periodo' => '2024-2025', 'orden' => 2],
            ['cargo' => 'Vocal', 'nombre' => 'DRA. PRESCILA MÉNDEZ PAYEHUANCA', 'periodo' => '2024-2025', 'orden' => 3],
        ];

        foreach ($tribunal as $t) {
            \App\Models\MiembroColegio::create(array_merge($t, [
                'tipo' => 'tribunal_honor',
            ]));
        }

        // 4. DECANOS HISTÓRICOS
        $historico = [
            ['nombre' => 'DR. JUAN PÉREZ', 'periodo' => '2022-2023', 'orden' => 1],
            ['nombre' => 'DRA. MARÍA RODRÍGUEZ', 'periodo' => '2020-2021', 'orden' => 2],
            ['nombre' => 'DR. CARLOS LÓPEZ', 'periodo' => '2018-2019', 'orden' => 3],
        ];

        foreach ($historico as $h) {
            \App\Models\MiembroColegio::create(array_merge($h, [
                'tipo' => 'decano_historico',
            ]));
        }
    }
}
