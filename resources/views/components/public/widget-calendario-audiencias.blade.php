@php
    // Obtener todos los eventos para el calendario visual
    $todosEventos = \App\Models\Evento::orderBy('fecha_inicio', 'asc')->get();
    
    // Agrupar eventos por fecha para el calendario JS con todos los datos necesarios
    $eventosJson = $todosEventos->map(function($e) {
        return [
            'id' => $e->id,
            'title' => $e->titulo,
            'description' => $e->descripcion,
            'start' => \Carbon\Carbon::parse($e->fecha_inicio)->format('Y-m-d'),
            'time' => \Carbon\Carbon::parse($e->fecha_inicio)->format('H:i'),
            'day' => \Carbon\Carbon::parse($e->fecha_inicio)->format('d'),
            'month' => \Carbon\Carbon::parse($e->fecha_inicio)->translatedFormat('M'),
            'type' => $e->tipo ?? 'Actividad',
            'location' => $e->ubicacion ?? '',
            'color' => $e->color ?? '#007bff',
            'url' => route('public.eventos') . '#' . $e->id
        ];
    })->toJson();
@endphp

<section class="py-5 event-calendar-section" style="background: #fbfcfe; position: relative;" id="calendario-municipal">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="display-5 fw-bold text-dark mb-0">Calendario de <span class="text-primary">Actividades</span></h2>
                <div class="title-divider mx-auto mt-3" style="width: 50px; height: 3px; background-color: var(--bs-primary); border-radius: 2px;"></div>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            {{-- Columna del Calendario --}}
            <div class="col-lg-7 col-xl-6">
                <div class="datepicker-wrapper shadow-xl border-0 p-4">
                    <div class="datepicker-header d-flex justify-content-between align-items-center mb-4">
                        <button class="dp-nav-btn prev-month"><i class="fas fa-chevron-left"></i></button>
                        <h4 class="mb-0 fw-bold current-month-display text-dark">--</h4>
                        <button class="dp-nav-btn next-month"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    
                    <div class="datepicker-grid" id="calendar-grid">
                        {{-- Generado por JS --}}
                    </div>

                    <div class="datepicker-footer mt-4 pt-4 border-top d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center"><span class="dp-dot bg-primary me-2"></span> <small class="text-muted">Evento</small></div>
                            <div class="d-flex align-items-center"><span class="dp-dot bg-success me-2"></span> <small class="text-muted">Hoy</small></div>
                        </div>
                        <a href="{{ route('public.eventos') }}" class="btn btn-sm btn-link text-decoration-none fw-bold text-primary d-lg-none">
                            Ver todo el mes <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Columna de Detalles (Solo Desktop) --}}
            <div class="col-lg-5 col-xl-5 d-none d-lg-flex">
                <div class="desktop-event-panel shadow-xl p-4 bg-white flex-grow-1" style="border-radius: 30px; position: sticky; top: 100px; max-height: 600px; border: 1px solid rgba(0,0,0,0.05); display: flex; flex-direction: column;">
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom flex-shrink-0">
                         <div class="icon-box-primary me-3" style="width: 45px; height: 45px; background: var(--primary-color); color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-check"></i>
                         </div>
                         <div>
                            <h5 class="fw-bold text-dark mb-0" id="desktop-date-title">Actividades</h5>
                            <small class="text-muted text-uppercase ls-1 fw-bold" style="font-size: 0.65rem;">Información detallada</small>
                         </div>
                    </div>
                    
                    <div id="desktop-event-content" class="flex-grow-1 custom-scrollbar" style="overflow-y: auto;">
                        {{-- Dinámico con JS --}}
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-top flex-shrink-0">
                        <a href="{{ route('public.eventos') }}" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm">
                            Ver Calendario Completo <i class="fas fa-chevron-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para mostrar eventos (Solo Móvil) --}}
    <div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
                <div class="modal-header border-0 pb-0 pe-4 pt-4">
                    <h5 class="modal-title fw-bold text-dark" id="modalDateTitle">Eventos del día</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 custom-scrollbar" id="modalEventsContent" style="max-height: 60vh; overflow-y: auto;">
                    {{-- Dinámico con JS --}}
                </div>
                <div class="modal-footer border-0 p-3 bg-light d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Cerrar</button>
                    <a href="{{ route('public.eventos') }}" class="btn btn-primary px-4 rounded-pill fw-bold">Ver Todo</a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Estilos Calendario Compacto (Datepicker) */
    .datepicker-wrapper {
        background: white;
        border-radius: 30px;
    }

    .dp-nav-btn {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        border: none;
        background: #f1f5f9;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .dp-nav-btn:hover { background: var(--primary-color); color: white; }

    .datepicker-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }

    .dp-weekday {
        text-align: center;
        font-weight: 700;
        font-size: 0.7rem;
        color: #94a3b8;
        padding-bottom: 15px;
        text-transform: uppercase;
    }

    .dp-day {
        aspect-ratio: 1/1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 50%;
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
        color: #334155;
    }
    .dp-day:hover { background: #f1f5f9; color: var(--primary-color); }
    
    .dp-day.today {
        background: #f0fdf4;
        color: #166534;
        box-shadow: inset 0 0 0 1px #86efac;
    }
    
    .dp-day.selected {
        background: var(--primary-color) !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .dp-day.has-event {
        color: var(--primary-color);
        font-weight: 800;
    }
    
    .dp-day.has-event::after {
        content: '';
        position: absolute;
        bottom: 6px;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 50%;
    }
    
    .dp-day.selected.has-event::after { background: white; }

    .dp-day.other-month { opacity: 0.2; pointer-events: none; }

    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Event Animation */
    .event-item-mini { animation: slideInEvent 0.4s ease-out; }
    @keyframes slideInEvent {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const eventos = {!! $eventosJson !!};
    let currentDate = new Date();
    let selectedDateStr = null;
    
    const grid = document.getElementById('calendar-grid');
    const monthDisplay = document.querySelector('.current-month-display');
    const prevBtn = document.querySelector('.prev-month');
    const nextBtn = document.querySelector('.next-month');
    
    const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
    const modalContent = document.getElementById('modalEventsContent');
    const modalTitle = document.getElementById('modalDateTitle');
    
    const desktopContent = document.getElementById('desktop-event-content');
    const desktopTitle = document.getElementById('desktop-date-title');

    function renderCalendar(dateToRender) {
        grid.innerHTML = '';
        const weekdays = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        weekdays.forEach(day => {
            const el = document.createElement('div');
            el.className = 'dp-weekday text-center';
            el.textContent = day;
            grid.appendChild(el);
        });

        const year = dateToRender.getFullYear();
        const month = dateToRender.getMonth();
        monthDisplay.textContent = new Intl.DateTimeFormat('es-ES', { month: 'long', year: 'numeric' }).format(dateToRender);

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const prevMonthLastDay = new Date(year, month, 0).getDate();

        // Días del mes anterior
        for (let i = firstDay; i > 0; i--) {
            const dayEl = document.createElement('div');
            dayEl.className = 'dp-day other-month';
            dayEl.textContent = prevMonthLastDay - i + 1;
            grid.appendChild(dayEl);
        }

        // Días del mes actual
        for (let i = 1; i <= daysInMonth; i++) {
            const dayEl = document.createElement('div');
            dayEl.className = 'dp-day';
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            dayEl.textContent = i;
            
            // Hoy
            const todayStr = new Date().toISOString().split('T')[0];
            if (dateStr === todayStr) dayEl.classList.add('today');
            
            // Seleccionado
            if (dateStr === selectedDateStr) dayEl.classList.add('selected');

            // Tiene eventos?
            const dayEvents = eventos.filter(e => e.start === dateStr);
            if (dayEvents.length > 0) dayEl.classList.add('has-event');

            dayEl.addEventListener('click', () => {
                selectedDateStr = dateStr;
                const formattedDate = new Date(dateStr + 'T00:00:00').toLocaleDateString('es-ES', { day: 'numeric', month: 'long', year: 'numeric' });
                refreshUI();
                handleDateAction(dayEvents, formattedDate);
            });

            grid.appendChild(dayEl);
        }

        // Rellenar hasta 42 celdas
        const totalCells = grid.children.length - 7;
        const remaining = 42 - totalCells;
        for (let i = 1; i <= remaining; i++) {
            const d = document.createElement('div');
            d.className = 'dp-day other-month';
            d.textContent = i;
            grid.appendChild(d);
        }
    }

    function refreshUI() {
        renderCalendar(currentDate);
    }

    function handleDateAction(dayEvents, dateLabel) {
        if (window.innerWidth >= 992) {
            // Desktop: Actualizar Panel Lateral
            renderEventsInContainer(dayEvents, dateLabel, desktopContent, desktopTitle);
        } else {
            // Mobile: Mostrar Modal (solo si hay eventos o por consistencia)
            renderEventsInContainer(dayEvents, dateLabel, modalContent, modalTitle);
            eventModal.show();
        }
    }

    function renderEventsInContainer(dayEvents, dateLabel, container, titleEl) {
        titleEl.textContent = dateLabel;
        
        if (dayEvents.length === 0) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <div class="mb-3 text-muted" style="opacity: 0.1;"><i class="fas fa-calendar-times fa-4x"></i></div>
                    <p class="text-muted small">No hay actividades programadas<br>para esta fecha.</p>
                </div>
            `;
            return;
        }

        let html = '';
        dayEvents.forEach((event, index) => {
            html += `
                <div class="event-item-mini ${index > 0 ? 'mt-4 pt-4 border-top' : ''}">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 52px; height: 52px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: white; border-radius: 12px; display: flex; flex-direction: column; justify-content: center; align-items: center; margin-right: 15px; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            <span style="font-size: 1.1rem; font-weight: 800; line-height: 1;">${event.day}</span>
                            <span style="font-size: 0.55rem; text-transform: uppercase;">${event.month}</span>
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <span class="badge rounded-pill mb-1" style="background: ${event.color}15; color: ${event.color}; font-size: 0.65rem; font-weight: 700; text-transform: uppercase;">${event.type}</span>
                            <div class="text-muted d-flex align-items-center" style="font-size: 0.75rem;">
                                <i class="far fa-clock me-1 text-primary"></i> ${event.time}
                                ${event.location ? `<i class="fas fa-map-marker-alt ms-3 me-1 text-danger"></i> <span class="text-truncate" title="${event.location}">${event.location}</span>` : ''}
                            </div>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-2 text-dark" style="font-size: 0.95rem; line-height: 1.4;">${event.title}</h6>
                    <p class="text-muted mb-3" style="font-size: 0.8rem; line-height: 1.5;">${event.description}</p>
                    <a href="${event.url}" class="btn btn-sm btn-outline-primary px-3 rounded-pill fw-bold" style="font-size: 0.7rem;">
                        Ver ficha <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            `;
        });
        
        container.innerHTML = html;
        container.scrollTop = 0;
    }

    function init() {
        const today = new Date();
        const todayStr = today.toISOString().split('T')[0];
        
        let initialDateStr = todayStr;
        let dayEvents = eventos.filter(e => e.start === todayStr);

        if (dayEvents.length === 0 && eventos.length > 0) {
            // Buscar el más cercano
            let minDiff = Infinity;
            eventos.forEach(e => {
                const diff = Math.abs(new Date(e.start + 'T00:00:00') - today);
                if (diff < minDiff) {
                    minDiff = diff;
                    initialDateStr = e.start;
                }
            });
            dayEvents = eventos.filter(e => e.start === initialDateStr);
        }

        selectedDateStr = initialDateStr;
        currentDate = new Date(initialDateStr + 'T00:00:00');
        
        const formattedDate = currentDate.toLocaleDateString('es-ES', { day: 'numeric', month: 'long', year: 'numeric' });
        renderCalendar(currentDate);
        
        // En desktop cargamos el contenido inicial en el panel. En móvil no abrimos el modal solo.
        if (window.innerWidth >= 992) {
            renderEventsInContainer(dayEvents, formattedDate, desktopContent, desktopTitle);
        } else {
             // En móvil cargamos silencio en el panel por si giran el dispositivo
             renderEventsInContainer(dayEvents, formattedDate, desktopContent, desktopTitle);
        }
    }

    prevBtn.addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() - 1); renderCalendar(currentDate); });
    nextBtn.addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() + 1); renderCalendar(currentDate); });

    init();
});
</script>
