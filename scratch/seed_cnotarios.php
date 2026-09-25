<?php

use Illuminate\Support\Facades\DB;
use App\Models\Pagina;
use App\Models\Menu;
use App\Models\Banner;
use App\Models\FotoAniversario;
use App\Models\ConfiguracionSitio;
use App\Models\Tema;
use App\Models\AccesoDirecto;
use App\Models\Noticia;

use App\Models\Plantilla;
use App\Models\Servicio;

// Limpiar tablas
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
Menu::truncate();
Pagina::truncate();
Banner::truncate();
FotoAniversario::truncate();
ConfiguracionSitio::truncate();
Tema::truncate();
AccesoDirecto::truncate();
Noticia::truncate();
Plantilla::truncate();
Servicio::truncate();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

// 1. Configuración del Sitio
$config = [
    ['clave' => 'nombre_sitio', 'valor' => 'Colegio de Notarios de Tacna', 'tipo' => 'texto', 'categoria' => 'general', 'descripcion' => 'Nombre oficial de la institución'],
    ['clave' => 'lema_institucional', 'valor' => '"Dignidad y Ética al Servicio de la Fe Pública"', 'tipo' => 'texto', 'categoria' => 'general', 'descripcion' => 'Lema del Colegio'],
    ['clave' => 'direccion_contacto', 'valor' => 'Calle Hipólito Unanue N° 336, Cercado, Tacna', 'tipo' => 'texto', 'categoria' => 'contacto', 'descripcion' => 'Dirección física'],
    ['clave' => 'telefono_contacto', 'valor' => '(052) 630739', 'tipo' => 'texto', 'categoria' => 'contacto', 'descripcion' => 'Teléfono de oficina'],
    ['clave' => 'email_contacto', 'valor' => 'colegionotariostacna@gmail.com', 'tipo' => 'texto', 'categoria' => 'contacto', 'descripcion' => 'Email oficial'],
    ['clave' => 'horario_atencion', 'valor' => 'Lunes a Viernes: 8:00 AM - 4:00 PM', 'tipo' => 'texto', 'categoria' => 'contacto', 'descripcion' => 'Horario de atención'],
    ['clave' => 'logo_header', 'valor' => 'https://colegionotariostacna.org.pe/images/cnt_horinzontal_blanco.png', 'tipo' => 'imagen', 'categoria' => 'general', 'descripcion' => 'Logo para el encabezado'],
    ['clave' => 'logo_navbar', 'valor' => 'https://colegionotariostacna.org.pe/images/cnt_horinzontal_blanco.png', 'tipo' => 'imagen', 'categoria' => 'general', 'descripcion' => 'Logo para el navbar'],
    ['clave' => 'facebook_url', 'valor' => 'https://www.facebook.com/colegionotariostacna', 'tipo' => 'url', 'categoria' => 'social', 'descripcion' => 'Facebook'],
    ['clave' => 'barra_superior_activa', 'valor' => '1', 'tipo' => 'booleano', 'categoria' => 'general', 'descripcion' => 'Activa la barra superior'],
    ['clave' => 'barra_superior_texto', 'valor' => 'Bienvenidos al Portal Oficial del Colegio de Notarios de Tacna', 'tipo' => 'texto', 'categoria' => 'general', 'descripcion' => 'Texto de la barra superior'],
];
foreach ($config as $c) ConfiguracionSitio::create($c);

// 2. Plantillas
$plantillaLanding = Plantilla::create([
    'nombre' => 'Página de Inicio (Landing)',
    'slug' => 'landing',
    'descripcion' => 'Plantilla modular para la página principal del Colegio',
    'componentes' => ['banner', 'bienvenida', 'ley_notarial', 'servicios', 'noticias', 'enlaces_interes'],
    'configuracion' => [
        'banner' => ['activo' => true, 'orden' => 1, 'ancho_completo' => true],
        'bienvenida' => ['activo' => true, 'orden' => 2, 'fondo' => 'white'],
        'ley_notarial' => ['activo' => true, 'orden' => 3, 'fondo' => 'light'],
        'servicios' => ['activo' => true, 'orden' => 4, 'fondo' => 'white', 'cantidad' => 4, 'columnas' => 4],
        'noticias' => ['activo' => true, 'orden' => 5, 'fondo' => 'white', 'cantidad' => 3],
        'enlaces_interes' => ['activo' => true, 'orden' => 6, 'fondo' => 'light']
    ],
    'activo' => true
]);

// 3. Temas
Tema::create([
    'nombre' => 'Tema Notarial Clásico v3',
    'slug' => 'tema-notarial',
    'descripcion' => 'Diseño inspirado en el verde institucional y oro del Colegio.',
    'es_predeterminado' => true,
    'color_primario' => '#2e7d32', 
    'color_secundario' => '#c5a059', 
    'color_acento' => '#43a047', 
    'color_fondo' => '#ffffff',
    'color_texto' => '#1a1a1a',
    'fuente_principal' => 'Montserrat',
    'fuente_secundaria' => 'Inter',
    'tamano_fuente' => '16px',
    'color_navbar' => '#f1f8f1',
    'estilo_navbar' => 'sticky',
    'navbar_altura' => 80,
    'configuracion' => ['widgets' => ['banner', 'bienvenida', 'ley_notarial', 'servicios', 'noticias', 'enlaces_interes']],
    'activo' => true
]);

// 4. Servicios
$servicios = [
    ['nombre' => 'Legalización de firmas', 'descripcion' => 'Legalización de firmas en documentos que van a ser remitidos al exterior.', 'icono' => 'fas fa-stamp', 'activo' => true, 'orden' => 1, 'url' => '/servicios-cnt'],
    ['nombre' => 'Capacitación Permanente', 'descripcion' => 'Formación a los miembros de la orden y sus colaboradores.', 'icono' => 'fas fa-graduation-cap', 'activo' => true, 'orden' => 2, 'url' => '/servicios-cnt'],
    ['nombre' => 'Orientación Notarial', 'descripcion' => 'Consultas y orientación para trámites notariales seguros.', 'icono' => 'fas fa-info-circle', 'activo' => true, 'orden' => 3, 'url' => '/servicios-cnt'],
    ['nombre' => 'Archivos Notariales', 'descripcion' => 'Gestión y consulta de archivos de ex notarios de Tacna.', 'icono' => 'fas fa-archive', 'activo' => true, 'orden' => 4, 'url' => '/servicios-cnt'],
];
foreach ($servicios as $s) Servicio::create($s);

// 5. Páginas
$paginas = [
    [
        'titulo' => 'Inicio', 
        'slug' => 'inicio', 
        'plantilla_id' => $plantillaLanding->id,
        'descripcion' => 'Bienvenidos al Portal del Colegio de Notarios de Tacna', 
        'contenido' => '
            <div class="welcome-section text-center mb-5">
                <h2 class="display-5 fw-bold mb-4" style="color: #1b5e20;">Colegio de Notarios de Tacna</h2>
                <p class="lead text-muted mx-auto" style="max-width: 900px;">En este espacio interactivo podrá encontrar información importante sobre las actividades realizadas por el CNT y los avances tecnológicos que impulsa para lograr un notariado moderno, de cara a la globalización.</p>
                
                <div class="law-highlight p-5 mt-5 border-0 rounded-4 shadow-lg text-start" style="background-color: #f8fdf8; border-left: 6px solid #2e7d32 !important;">
                    <h3 class="text-success fw-bold mb-3">LEY N°30908: Garantizar el Derecho de Libre Elección del Servicio Notarial</h3>
                    <p class="fs-5 text-dark mb-4">Estimado usuario, si va solicitar un crédito ante un Banco, Financiera o Casa Comercial, se le informa que, mediante la Ley N°30908, el Estado garantiza su derecho a contratar libremente al Notario de su elección. Para dicho efecto, ponemos a su disposición en la opción DIRECTORIO INSTITUCIONAL la relación actualizada de los notarios de Tacna, sus datos de contacto y su página web.</p>
                    <a href="/notarios" class="btn btn-success btn-lg px-5 py-3 fw-bold rounded-pill shadow">DIRECTORIO INSTITUCIONAL Clic Aquí</a>
                </div>
            </div>', 
        'tipo' => 'landing', 'activa' => true, 'mostrar_en_menu' => true, 'orden' => 1
    ],
    [
        'titulo' => 'Nuestros Servicios', 
        'slug' => 'servicios-cnt', 
        'descripcion' => 'Servicios institucionales del CNT', 
        'contenido' => '
            <div class="services-container">
                <h2 class="text-center mb-5 fw-bold" style="color: #1b5e20;">Nuestros Servicios</h2>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-success bg-opacity-10 text-success p-3 rounded-circle me-3">
                                    <i class="fas fa-stamp fa-2x"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Legalización del CNT</h5>
                            </div>
                            <p class="text-muted">Legalización de firmas de los Notarios de Tacna en documentos que van ser remitidos al exterior.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                                    <i class="fas fa-graduation-cap fa-2x"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Capacitación</h5>
                            </div>
                            <p class="text-muted">Capatización permanente a los miembros de la orden y sus colaboradores.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-info bg-opacity-10 text-info p-3 rounded-circle me-3">
                                    <i class="fas fa-info-circle fa-2x"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Orientación</h5>
                            </div>
                            <p class="text-muted">Orientación y Consultas Notariales para la ciudadanía de la región.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-dark bg-opacity-10 text-dark p-3 rounded-circle me-3">
                                    <i class="fas fa-archive fa-2x"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Archivos Notariales</h5>
                            </div>
                            <p class="text-muted">Información sobre Archivos de Ex Notarios de Tacna (Archivo Regional).</p>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <a href="/servicios-cnt" class="btn btn-outline-success btn-lg px-5 rounded-pill fw-bold">Conozca más detalles</a>
                </div>
            </div>', 
        'tipo' => 'pagina', 'activa' => true, 'mostrar_en_menu' => true, 'orden' => 7
    ],
    [
        'titulo' => 'Presentación', 
        'slug' => 'presentacion', 
        'descripcion' => 'Mensaje de bienvenida y datos de creación del Colegio', 
        'contenido' => '
            <div class="institutional-content">
                <h2 class="section-title mb-4" style="color: #1b5e20;">Presentación</h2>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="fs-5 text-muted mb-4">El Colegio de Notarios de Tacna le da la bienvenida y agradece su visita a nuestro portal institucional. Una herramienta de cara a la globalización y transparencia institucional.</p>
                        <p>A través de este espacio podrá conocernos, así como la función y actividades que realizamos al servicio de la comunidad, en resguardo de la seguridad jurídica y paz social de la región Tacna.</p>
                        <p>El avance tecnológico nos permite llegar hasta Ud., a través de esta herramienta informática, donde encontrará información relevante que nos permitirá también cumplir con la tarea de interoperabilidad entre las diferentes instituciones que brinda servicios al público en aras de la transparencia y accesibilidad a la información.</p>
                        
                        <div class="mt-5 p-4 bg-light rounded shadow-sm border-start border-4 border-success">
                            <h4 class="fw-bold text-success mb-3">DATOS DE CREACIÓN</h4>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">FECHA DE CREACIÓN</h6>
                                    <p class="small">Mediante escritura pública de fecha 30 DE MAYO DEL 2002, otorgada por ante la Notaria del Dr. Víctor Edilberto Lozano Valderrama.</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold">LEY DE CREACIÓN</h6>
                                    <p class="small">Ley Nº 27567 que modifica a los artículos 21º y 128º de la Ley del Notariado y Crea los Distritos Notariales de Tacna; de Moquegua; de Huánuco y Pasco; y de Ucayali.</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold">MODIFICACIÓN DE ESTATUTOS</h6>
                                    <p class="small">Acta de asamblea general extraordinaria de fecha 29 de diciembre del 2008, elevada a escritura pública el 22 de junio del 2009 ante la notaria de la Dra. Rosa María Málaga Cutipé.</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold">INSCRIPCIÓN SUNARP</h6>
                                    <p class="small">Partida Electrónica N° 11008024 del registro de personas jurídicas de Tacna.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>', 
        'tipo' => 'pagina', 'activa' => true, 'mostrar_en_menu' => true, 'orden' => 2
    ],
    [
        'titulo' => 'Misión y Visión', 
        'slug' => 'mision-vision', 
        'descripcion' => 'Objetivos y proyección estratégica', 
        'contenido' => '
            <div class="mission-vision-content py-3">
                <div class="row g-5">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 bg-light">
                            <div class="mb-3" style="color: #1b5e20;"><i class="fas fa-bullseye fa-3x"></i></div>
                            <h3 class="fw-bold mb-3" style="color: #1b5e20;">Misión</h3>
                            <p class="fs-5" style="line-height: 1.8;">Representar y agrupar a los notarios miembros del Colegio de Notarios de Tacna, para lograr el más alto nivel de profesionalismo y ética en el desempeño de sus funciones en forma personal, autónoma, exclusiva e imparcial, cumpliendo fielmente los principios y valores que orientan el actuar del notario.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 bg-white border">
                            <div class="mb-3" style="color: #c5a059;"><i class="fas fa-eye fa-3x"></i></div>
                            <h3 class="fw-bold mb-3" style="color: #c5a059;">Visión</h3>
                            <p class="fs-5" style="line-height: 1.8;">Ser reconocida como una institución sólida, que fomenta la práctica de valores y comportamiento ético de los notarios, fiscalizando su labor, así como contribuir con la interoperabilidad de la institución notarial con las diferentes entidades públicas y privadas haciendo uso de los instrumentos tecnológicos que permitan la seguridad y celeridad en las contrataciones.</p>
                        </div>
                    </div>
                </div>
            </div>', 
        'tipo' => 'pagina', 'activa' => true, 'mostrar_en_menu' => true, 'orden' => 3
    ],
    [
        'titulo' => 'Junta Directiva', 
        'slug' => 'junta-directiva', 
        'descripcion' => 'Autoridades del Colegio de Notarios de Tacna', 
        'contenido' => '
            <div class="board-content py-3">
                <h3 class="fw-bold text-center mb-5" style="color: #1b5e20;">Junta Directiva 2025 - 2027</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover shadow-sm align-middle">
                        <thead class="text-white text-center">
                            <tr>
                                <th class="py-3 px-4 text-white" style="background-color: #1b5e20; width: 40%;">CARGO</th>
                                <th class="py-3 px-4 text-white" style="background-color: #1b5e20;">NOMBRES Y APELLIDOS</th>
                            </tr>
                        </thead>
                        <tbody class="fs-5">
                            <tr><td class="fw-bold px-4">DECANO</td><td class="px-4">DR. VICENTE GUIDO QUISPE CHATA</td></tr>
                            <tr><td class="fw-bold px-4">VICEDECANO</td><td class="px-4">DR. LUIS REINERO VARGAS BELTRÁN</td></tr>
                            <tr><td class="fw-bold px-4">SECRETARIA</td><td class="px-4">DRA. ROSA MARÍA MÁLAGA CUTIPÉ</td></tr>
                            <tr><td class="fw-bold px-4">TESORERO</td><td class="px-4">DR. VÍCTOR EDILBERTO LOZANO VALDERRAMA</td></tr>
                            <tr><td class="fw-bold px-4">FISCAL</td><td class="px-4">DRA. LILIANA RAMOS ALARCÓN</td></tr>
                            <tr><td class="fw-bold px-4">VOCAL</td><td class="px-4">DR. EDGAR ARTURO PEREA SILVA</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>', 
        'tipo' => 'pagina', 'activa' => true, 'mostrar_en_menu' => true, 'orden' => 4
    ],
    [
        'titulo' => 'Tribunal de Honor', 
        'slug' => 'tribunal-honor', 
        'descripcion' => 'Órgano de control ético institucional', 
        'contenido' => '
            <div class="honor-content py-3">
                <h3 class="fw-bold text-center mb-5" style="color: #1b5e20;">Tribunal de Honor</h3>
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table table-bordered shadow-sm align-middle">
                                <thead class="text-white text-center">
                                    <tr>
                                        <th class="py-3 text-white" style="background-color: #2c3e50;">CARGO</th>
                                        <th class="py-3 text-white" style="background-color: #2c3e50;">NOMBRES Y APELLIDOS</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-5 text-center">
                                    <tr><td class="fw-bold p-3">PRESIDENTE</td><td class="p-3">DR. JORGE LUIS MÁLAGA CUTIPÉ</td></tr>
                                    <tr><td class="fw-bold p-3">MIEMBRO TITULAR 01</td><td class="p-3">DRA. LILIANA RAMOS ALARCÓN</td></tr>
                                    <tr><td class="fw-bold p-3">MIEMBRO TITULAR 02</td><td class="p-3">DR. EDGAR ARTURO PEREA SILVA</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>', 
        'tipo' => 'pagina', 'activa' => true, 'mostrar_en_menu' => true, 'orden' => 5
    ],
    [
        'titulo' => 'Decanos', 
        'slug' => 'decanos', 
        'descripcion' => 'Historial de autoridades del Colegio de Notarios de Tacna', 
        'contenido' => '
            <div class="deans-content py-3">
                <h3 class="fw-bold text-center mb-5" style="color: #1b5e20;">Relación Histórica de Decanos</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover shadow-sm align-middle">
                        <thead class="text-white text-center">
                            <tr>
                                <th class="py-3 text-white" style="background-color: #1b5e20; width: 30%;">PERIODO</th>
                                <th class="py-3 text-white" style="background-color: #1b5e20;">DECANO(A)</th>
                            </tr>
                        </thead>
                        <tbody class="fs-5">
                            <tr><td class="text-center fw-bold">2025 - 2027</td><td>DR. VICENTE GUIDO QUISPE CHATA (Actual)</td></tr>
                            <tr><td class="text-center">2023 - 2024</td><td>DR. VICENTE GUIDO QUISPE CHATA</td></tr>
                            <tr><td class="text-center">2019 - 2021</td><td>DRA. ROSA MARÍA MÁLAGA CUTIPÉ</td></tr>
                            <tr><td class="text-center">2017 - 2018</td><td>DR. LUIS REINERO VARGAS BELTRÁN</td></tr>
                            <tr><td class="text-center">2015 - 2016</td><td>DRA. ÁNGELA DÍAZ JARA ALMONTE</td></tr>
                            <tr><td class="text-center">2013 - 2014</td><td>DRA. ROSARIO BOHÓRQUEZ VEGA</td></tr>
                            <tr><td class="text-center">2005 - 2012</td><td>DR. VÍCTOR EDILBERTO LOZANO VALDERRAMA</td></tr>
                            <tr><td class="text-center">2002 - 2004</td><td>DRA. DAYSI MORALES DE BARRIENTOS</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>', 
        'tipo' => 'pagina', 'activa' => true, 'mostrar_en_menu' => true, 'orden' => 6
    ],
    ['titulo' => 'Directorio de Notarios', 'slug' => 'notarios', 'descripcion' => 'Búsqueda de notarios en Tacna', 'contenido' => '<p>Encuentre aquí a todos los notarios autorizados en la región Tacna.</p>', 'tipo' => 'notarios', 'activa' => true, 'mostrar_en_menu' => true, 'orden' => 8],
    ['titulo' => 'Galería de Fotos', 'slug' => 'galeria', 'descripcion' => 'Galería de fotos institucional', 'contenido' => '<p>Registro fotográfico de nuestras actividades.</p>', 'tipo' => 'pagina', 'activa' => true, 'mostrar_en_menu' => true, 'orden' => 9],
    ['titulo' => 'Contacto', 'slug' => 'contacto', 'descripcion' => 'Ubicación y medios de contacto', 'contenido' => '<p>Estamos a su servicio en nuestra sede institucional.</p>', 'tipo' => 'pagina', 'activa' => true, 'mostrar_en_menu' => true, 'orden' => 10],
];

$creadas = [];
foreach ($paginas as $p) {
    if ($existente = Pagina::where('slug', $p['slug'])->first()) {
        $existente->update($p);
        $creadas[$p['slug']] = $existente;
    } else {
        $creadas[$p['slug']] = Pagina::create($p);
    }
}
// 4. Menús
// INICIO
Menu::create(['nombre' => 'INICIO', 'ubicacion' => 'principal', 'tipo' => 'pagina', 'pagina_id' => $creadas['inicio']->id, 'url' => 'inicio', 'orden' => 1, 'activo' => true]);

// INSTITUCIONAL (Padre)
$inst = Menu::create(['nombre' => 'INSTITUCIONAL', 'ubicacion' => 'principal', 'tipo' => 'enlace_externo', 'url' => '#', 'orden' => 2, 'activo' => true]);

// SUBMENUS INSTITUCIONAL
Menu::create(['nombre' => 'Presentación', 'ubicacion' => 'principal', 'tipo' => 'pagina', 'pagina_id' => $creadas['presentacion']->id, 'url' => 'presentacion', 'parent_id' => $inst->id, 'orden' => 1, 'activo' => true]);
Menu::create(['nombre' => 'Misión y Visión', 'ubicacion' => 'principal', 'tipo' => 'pagina', 'pagina_id' => $creadas['mision-vision']->id, 'url' => 'mision-vision', 'parent_id' => $inst->id, 'orden' => 2, 'activo' => true]);
Menu::create(['nombre' => 'Junta Directiva', 'ubicacion' => 'principal', 'tipo' => 'pagina', 'pagina_id' => $creadas['junta-directiva']->id, 'url' => 'junta-directiva', 'parent_id' => $inst->id, 'orden' => 3, 'activo' => true]);
Menu::create(['nombre' => 'Tribunal de Honor', 'ubicacion' => 'principal', 'tipo' => 'pagina', 'pagina_id' => $creadas['tribunal-honor']->id, 'url' => 'tribunal-honor', 'parent_id' => $inst->id, 'orden' => 4, 'activo' => true]);
Menu::create(['nombre' => 'Decanos', 'ubicacion' => 'principal', 'tipo' => 'pagina', 'pagina_id' => $creadas['decanos']->id, 'url' => 'decanos', 'parent_id' => $inst->id, 'orden' => 5, 'activo' => true]);
Menu::create(['nombre' => 'Directorio de Notarios', 'ubicacion' => 'principal', 'tipo' => 'pagina', 'pagina_id' => $creadas['notarios']->id, 'url' => 'notarios', 'parent_id' => $inst->id, 'orden' => 6, 'activo' => true]);

// OTROS MENU PRINCIPAL
Menu::create(['nombre' => 'SERVICIOS', 'ubicacion' => 'principal', 'tipo' => 'pagina', 'pagina_id' => $creadas['servicios-cnt']->id, 'url' => 'servicios-cnt', 'orden' => 3, 'activo' => true]);
Menu::create(['nombre' => 'NOTICIAS', 'ubicacion' => 'principal', 'tipo' => 'enlace_externo', 'url' => 'noticias', 'orden' => 4, 'activo' => true]);
Menu::create(['nombre' => 'GALERÍA', 'ubicacion' => 'principal', 'tipo' => 'pagina', 'pagina_id' => $creadas['galeria']->id, 'url' => 'galeria', 'orden' => 5, 'activo' => true]);
Menu::create(['nombre' => 'CONTACTO', 'ubicacion' => 'principal', 'tipo' => 'pagina', 'pagina_id' => $creadas['contacto']->id, 'url' => 'contacto', 'orden' => 6, 'activo' => true]);

// 5. Banners
Banner::create(['titulo' => 'Colegio de Notarios de Tacna', 'subtitulo' => 'Seguridad Jurídica y Fe Pública', 'descripcion' => 'Representamos a los notarios de la región con ética y profesionalismo.', 'imagen_url' => 'storage/fotos_aniversario/FOTO_GENERAL_ELEGANTE.jpeg', 'boton_texto' => 'Ver Más', 'boton_url' => '/presentacion', 'orden' => 1, 'activo' => true]);
Banner::create(['titulo' => 'Gestión Institucional 2025 - 2027', 'subtitulo' => 'Comprometidos con el Notariado', 'descripcion' => 'Nueva Junta Directiva trabajando por la institución.', 'imagen_url' => 'storage/fotos_aniversario/JUNTA_DIRECTIVA_2025_2027.jpeg', 'boton_texto' => 'Ver Autoridades', 'boton_url' => '/junta-directiva', 'orden' => 2, 'activo' => true]);
Banner::create(['titulo' => 'Día del Notario', 'subtitulo' => 'Celebración Institucional', 'descripcion' => 'Homenaje a la labor notarial en nuestra región.', 'imagen_url' => 'storage/fotos_aniversario/CELEBRACION_DIA_DEL_NOTARIO.jpeg', 'boton_texto' => 'Galería', 'boton_url' => '/galeria', 'orden' => 3, 'activo' => true]);

// 6. Fotos
$fotosData = [
    ['titulo' => 'Izamiento del Pabellón Nacional', 'descripcion' => 'Acto protocolar por el Día del Notario 2024.', 'anio' => 2024, 'imagen' => 'storage/fotos_aniversario/DIA_DEL_NOTARIO_2024_IZAMIENTO_PABELLON_NACIONAL.jpeg', 'nombre_actividad' => 'Celebración Institucional', 'orden' => 1, 'activo' => true],
    ['titulo' => 'Día del Notario 2024', 'descripcion' => 'Sesión solemne con presencia de autoridades.', 'anio' => 2024, 'imagen' => 'storage/fotos_aniversario/DIA_DEL_NOTARIO_2024_IZAMIENTO_PABELLON_NACIONAL_2.jpeg', 'nombre_actividad' => 'Celebración Institucional', 'orden' => 2, 'activo' => true],
    ['titulo' => 'Celebración por el Día del Notario', 'descripcion' => 'Reunión institucional de los miembros de la orden.', 'anio' => 2024, 'imagen' => 'storage/fotos_aniversario/CELEBRACION_DIA_DEL_NOTARIO.jpeg', 'nombre_actividad' => 'Celebración Institucional', 'orden' => 3, 'activo' => true],
    ['titulo' => 'Aniversario Institucional', 'descripcion' => 'Participación de la orden notarial en actividades cívicas.', 'anio' => 2024, 'imagen' => 'storage/fotos_aniversario/DIA_DEL_NOTARIO_2.jpeg', 'nombre_actividad' => 'Celebración Institucional', 'orden' => 4, 'activo' => true],
    ['titulo' => 'Reconocimiento por Trayectoria', 'descripcion' => 'Entrega de distinciones por 30 años de función notarial.', 'anio' => 2024, 'imagen' => 'storage/fotos_aniversario/PERSONAS_CUMPLIERON_30_ANIOS_FUNCION_NOTARIAL.jpeg', 'nombre_actividad' => 'Aniversario Institucional', 'orden' => 1, 'activo' => true],
    ['titulo' => '30 Años de Función Notarial', 'descripcion' => 'Homenaje a la trayectoria y servicio profesional.', 'anio' => 2024, 'imagen' => 'storage/fotos_aniversario/30_ANIOS_FUNCION_NOTARIAL.jpeg', 'nombre_actividad' => 'Aniversario Institucional', 'orden' => 2, 'activo' => true],
    ['titulo' => 'Juramentación del Decano', 'descripcion' => 'Acto de asunción al cargo para el periodo 2025-2027.', 'anio' => 2025, 'imagen' => 'storage/fotos_aniversario/JURAMENTACION_NUEVO_DECANO_ENERO_2025.jpeg', 'nombre_actividad' => 'Gestión Institucional', 'orden' => 1, 'activo' => true],
    ['titulo' => 'Decano del Colegio de Notarios', 'descripcion' => 'Distinción institucional en el acto de juramentación.', 'anio' => 2025, 'imagen' => 'storage/fotos_aniversario/ENERO_2025_NUEVO_DECANO.jpeg', 'nombre_actividad' => 'Gestión Institucional', 'orden' => 2, 'activo' => true],
    ['titulo' => 'Junta Directiva 2025 - 2027', 'descripcion' => 'Cuerpo directivo institucional para el presente bienio.', 'anio' => 2025, 'imagen' => 'storage/fotos_aniversario/JUNTA_DIRECTIVA_2025_2027.jpeg', 'nombre_actividad' => 'Gestión Institucional', 'orden' => 3, 'activo' => true],
    ['titulo' => 'Miembros de la Orden', 'descripcion' => 'Reunión protocolar de los notarios de la región.', 'anio' => 2025, 'imagen' => 'storage/fotos_aniversario/FOTO_GRUPAL_ELEGANTE.jpeg', 'nombre_actividad' => 'Gestión Institucional', 'orden' => 4, 'activo' => true],
    ['titulo' => 'Tribunal de Honor', 'descripcion' => 'Presidenta y miembros encargados de la ética institucional.', 'anio' => 2025, 'imagen' => 'storage/fotos_aniversario/PRESIDENTA_TRIBUNAL_MIEMBROS_TRIBUNAL.jpeg', 'nombre_actividad' => 'Autoridades', 'orden' => 1, 'activo' => true],
    ['titulo' => 'Decano y Tesorero', 'descripcion' => 'Autoridades en funciones administrativas.', 'anio' => 2025, 'imagen' => 'storage/fotos_aniversario/DECANO_TESORERO.jpeg', 'nombre_actividad' => 'Autoridades', 'orden' => 2, 'activo' => true],
    ['titulo' => 'Decano y Secretaria de Juramentación', 'descripcion' => 'Acto institucional de fe pública.', 'anio' => 2025, 'imagen' => 'storage/fotos_aniversario/DECANO_SECRETARIA_DE_JURAMENTACION.jpeg', 'nombre_actividad' => 'Autoridades', 'orden' => 3, 'activo' => true],
];
foreach ($fotosData as $f) FotoAniversario::create($f);

// 7. Noticias (Desde JSON)
$noticiasData = [
    ['titulo' => 'PRESENTACIÓN DE NUEVA JUNTA DIRECTIVA 2017-2019 CNT', 'contenido' => 'El Colegio de Notarios de Tacna presenta a la nueva Junta Directiva del CNT correspondiente al período 2017-2019, conformada por, el Decano: Dr. Luis Reinero Vargas Beltrán, Fiscal: Dra. Angela María Díaz Jara Almonte, Secretaria: Dra. Prescila Méndez Payehuanca y Tesorera: Dra. Rosario Catherine Bohórquez Vega.', 'fecha_publicacion' => '2017-11-30', 'categoria' => 'Institucional'],
    ['titulo' => 'FINALIZÓ EL DIPLOMADO EN DERECHO CIVIL Y REGISTRAL', 'contenido' => 'El Colegio de Notarios de Tacna en forma conjunta con el Círculo de Estudios Jurídicos "Ius Nova" organizaron el "Diplomado de Especialización en Derecho Civil Registral", llevado a cabo desde el 25 de Setiembre al 25 de Noviembre 2017.', 'fecha_publicacion' => '2017-11-30', 'categoria' => 'Capacitación'],
    ['titulo' => 'CELEBRACIÓN DÍA DEL NOTARIADO PERUANO', 'contenido' => 'El 02 de Octubre 2017 los miembros de la orden del Colegio de Notarios de Tacna celebraron el Día del Notariado Peruano, compartiendo un Almuerzo de Camaradería en las instalaciones del Hotel Tacna.', 'fecha_publicacion' => '2017-11-30', 'categoria' => 'Eventos'],
    ['titulo' => 'ACTIVIDADES DICIEMBRE 2017', 'contenido' => 'El Colegio de Notarios de Tacna, tiene programado para este mes de Diciembre llevar a cabo un Curso de Capacitación 2017 y la Celebración de la Navidad 2017.', 'fecha_publicacion' => '2017-11-30', 'categoria' => 'Eventos'],
    ['titulo' => 'PRESENTACIÓN DE NUEVO TRIBUNAL DE HONOR 2017-2019 CNT', 'contenido' => 'El Colegio de Notarios de Tacna presenta al nuevo Tribunal de Honor CNT, correspondiente al período 2017-2019, conformado por, la Presidenta: Dra. Rosa María Málaga Cutipé, M.1: Dr. Germán Valdéz Meneses, M.2: Dr. Karim Israel Sarabia Palza.', 'fecha_publicacion' => '2017-11-30', 'categoria' => 'Institucional'],
    ['titulo' => 'VISITAS DE INSPECCIÓN NOTARIAL - AÑO 2017', 'contenido' => 'Para este año 2017, el Colegio de Notarios de Tacna, ha realizado las Visitas de Inspección a los Oficios Notariales de los miembros de la orden durante el mes de Noviembre 2017.', 'fecha_publicacion' => '2017-11-30', 'categoria' => 'Control'],
    ['titulo' => 'INVITACIÓN A JORNADA DE CAPACITACIÓN 2017', 'contenido' => 'El Colegio de Notarios de Tacna, invita a los miembros de la orden y colaboradores a la "Jornada de Capacitación Académica 2017" con los temas de Impuesto a la Renta y Lavado de Activos.', 'fecha_publicacion' => '2017-12-15', 'categoria' => 'Capacitación'],
    ['titulo' => 'ASAMBLEA GENERAL EXTRAORDINARIA 2018', 'contenido' => 'El Colegio de Notarios de Tacna ha iniciado este año 2018 convocando a todos los miembros de la orden a la Asamblea General Extraordinaria que se llevó a cabo en las instalaciones del Club Unión de Tacna.', 'fecha_publicacion' => '2018-02-13', 'categoria' => 'Institucional'],
    ['titulo' => 'SEMINARIO DE ACTUALIZACION NOTARIAL DEL SUR', 'contenido' => 'El Colegio de Notarios de Tacna con el auspicio de la Junta de Decanos de los Colegios de Notarios del Perú, presenta para este sábado 03 de Agosto del 2019 el Seminario de Actualización Notarial del Sur.', 'fecha_publicacion' => '2019-07-25', 'categoria' => 'Capacitación'],
    ['titulo' => 'ESTADO DE EMERGENCIA NACIONAL - COVID-19', 'contenido' => 'En cumplimiento de lo dispuesto por el decreto supremo emitido por el gobierno, se suspenden los plazos establecidos para todos los procedimientos no contenciosos previstos en la legislación notarial.', 'fecha_publicacion' => '2020-03-15', 'categoria' => 'Comunicados'],
    ['titulo' => 'COMUNICADO: ATENCIÓN PREVIA CITA', 'contenido' => 'SE COMUNICA QUE LA ATENCIÓN DEL COLEGIO DE NOTARIOS DE TACNA SERÁ PREVIA CITA A LOS NROS 052-630739 - 944590905 Y/O CONSULTAS AL CORREO colegionotariostacna@gmail.com.', 'fecha_publicacion' => '2020-06-08', 'categoria' => 'Comunicados'],
    ['titulo' => 'GARANTIZAR EL DERECHO DE LIBRE ELECCIÓN DEL SERVICIO NOTARIAL', 'contenido' => 'Mediante la Ley N°30908, el Estado garantiza su derecho a contratar libremente al Notario de su elección. Ponemos a su disposición el DIRECTORIO INSTITUCIONAL actualizado.', 'fecha_publicacion' => '2020-06-08', 'categoria' => 'Informativo'],
    ['titulo' => 'NOTARIOS DE TACNA EN FUNCIONES', 'contenido' => 'Relación actualizada y servicios de los notarios de la orden en el distrito notarial de Tacna.', 'fecha_publicacion' => '2020-08-17', 'categoria' => 'Institucional'],
];

foreach ($noticiasData as $n) {
    Noticia::create([
        'titulo' => $n['titulo'],
        'slug' => \Illuminate\Support\Str::slug($n['titulo']),
        'resumen' => \Illuminate\Support\Str::limit(strip_tags($n['contenido']), 150),
        'contenido' => '<p>' . nl2br($n['contenido']) . '</p>',
        'fecha_publicacion' => $n['fecha_publicacion'],
        'categoria' => $n['categoria'],
        'publicada' => true,
        'autor' => 'Colegio de Notarios'
    ]);
}

// 8. Accesos Directos
$accesos = [
    ['tipo' => 'lema', 'titulo' => 'Dignidad y Ética al Servicio de la Fe Pública', 'url' => '#', 'fuente_tamano' => '13', 'fuente_familia' => 'inherit', 'color' => '#ffffff', 'target' => '_self', 'descripcion' => 'Lema institucional', 'mostrar_en_barra_superior' => true, 'orden' => 1, 'activo' => true],
    
    // Top Bar Enlaces (Enlaces rápidos superiores)
    ['tipo' => 'enlace', 'titulo' => 'Noticias', 'url' => '/noticias', 'icono' => 'fas fa-newspaper', 'color' => '#ffffff', 'mostrar_en_barra_superior' => true, 'orden' => 2, 'activo' => true],
    ['tipo' => 'enlace', 'titulo' => 'Directorio', 'url' => '/notarios', 'icono' => 'fas fa-search', 'color' => '#ffffff', 'mostrar_en_barra_superior' => true, 'orden' => 3, 'activo' => true],
    ['tipo' => 'enlace', 'titulo' => 'Contacto', 'url' => '/contacto', 'icono' => 'fas fa-phone-alt', 'color' => '#ffffff', 'mostrar_en_barra_superior' => true, 'orden' => 4, 'activo' => true],
    
    // Header Enlaces (Accesos Directos al lado del logo)
    ['tipo' => 'enlace', 'titulo' => 'NOTICIAS', 'url' => '/noticias', 'icono' => 'fas fa-newspaper', 'color' => '#2e7d32', 'mostrar_en_header' => true, 'orden' => 1, 'activo' => true],
    ['tipo' => 'enlace', 'titulo' => 'SERVICIOS', 'url' => '/servicios-cnt', 'icono' => 'fas fa-file-contract', 'color' => '#2e7d32', 'mostrar_en_header' => true, 'orden' => 2, 'activo' => true],
    ['tipo' => 'enlace', 'titulo' => 'GALERÍA', 'url' => '/galeria', 'icono' => 'fas fa-images', 'color' => '#2e7d32', 'mostrar_en_header' => true, 'orden' => 3, 'activo' => true],
];
foreach ($accesos as $a) AccesoDirecto::create($a);

echo "Importación completa: Accesos e integración de Barra de Título finalizada.";
