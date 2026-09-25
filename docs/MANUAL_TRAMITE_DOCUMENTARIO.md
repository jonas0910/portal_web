# 📋 Manual del Subsistema de Trámite Documentario

## Municipalidad - Sistema de Gestión de Trámites

---

## Índice

1. [Introducción](#1-introducción)
2. [Acceso al Sistema](#2-acceso-al-sistema)
3. [Portal Público - Ciudadano](#3-portal-público---ciudadano)
4. [Panel de Administración](#4-panel-de-administración)
5. [Gestión de Áreas](#5-gestión-de-áreas)
6. [Gestión de Tipos de Trámite](#6-gestión-de-tipos-de-trámite)
7. [Gestión de Trámites](#7-gestión-de-trámites)
8. [Seguimiento y Trazabilidad](#8-seguimiento-y-trazabilidad)
9. [Estados del Trámite](#9-estados-del-trámite)
10. [Reportes y Estadísticas](#10-reportes-y-estadísticas)

---

## 1. Introducción

El **Subsistema de Trámite Documentario** es una solución integral que permite a los ciudadanos realizar trámites de manera virtual y a los funcionarios gestionar el flujo documental de manera eficiente.

### Características Principales

- ✅ Ingreso de trámites desde el portal web público
- ✅ Consulta de estado de trámites en línea
- ✅ Gestión completa de expedientes
- ✅ Derivación entre áreas
- ✅ Seguimiento y trazabilidad completa
- ✅ Adjuntar documentos digitales
- ✅ Notificaciones por correo electrónico
- ✅ Reportes y estadísticas

---

## 2. Acceso al Sistema

### Portal Público (Ciudadanos)
```
URL: http://[dominio]/tramites
```

### Panel de Administración (Funcionarios)
```
URL: http://[dominio]/admin/tramites
Requiere: Usuario y contraseña con permisos de administración
```

---

## 3. Portal Público - Ciudadano

### 3.1 Página Principal de Trámites

Acceda a `/tramites` para ver las opciones disponibles:

| Opción | Descripción |
|--------|-------------|
| **Ingresar Nuevo Trámite** | Registrar una nueva solicitud o documento |
| **Consultar Estado** | Verificar el estado de un trámite existente |

### 3.2 Ingresar un Nuevo Trámite

1. Haga clic en **"Iniciar Trámite"**
2. Complete el formulario con los siguientes datos:

#### Datos del Solicitante
| Campo | Descripción | Obligatorio |
|-------|-------------|-------------|
| Tipo de Documento | DNI, RUC, Carnet de Extranjería, Pasaporte | Sí |
| Número de Documento | Número del documento de identidad | Sí |
| Nombres | Nombres del solicitante | Sí |
| Apellidos | Apellidos del solicitante | Sí |
| Email | Correo electrónico para notificaciones | Sí |
| Teléfono | Número de contacto | Sí |
| Dirección | Dirección domiciliaria | No |

#### Datos del Trámite
| Campo | Descripción | Obligatorio |
|-------|-------------|-------------|
| Tipo de Trámite | Seleccione el tipo de trámite a realizar | Sí |
| Asunto | Descripción breve del trámite | Sí |
| Descripción | Detalle completo de la solicitud | No |
| Folios | Cantidad de folios del documento | No |
| Documentos Adjuntos | Archivos PDF, Word o imágenes (máx. 5MB c/u) | Según tipo |

3. Haga clic en **"Enviar Trámite"**
4. Guarde el **Número de Expediente** y **Código de Verificación**

### 3.3 Consultar Estado de un Trámite

1. Acceda a **"Consultar Estado"** o `/tramites/consulta`
2. Ingrese:
   - Número de Expediente (ej: EXP-2025-000001)
   - Código de Verificación
3. Haga clic en **"Consultar"**

La consulta mostrará:
- Estado actual del trámite
- Área donde se encuentra
- Historial de movimientos
- Documentos adjuntos (si son públicos)
- Días transcurridos y fecha límite

---

## 4. Panel de Administración

### 4.1 Dashboard de Trámites

Acceda a `/admin/tramites` para ver el dashboard principal con:

- **Estadísticas generales**: Total, pendientes, en proceso, atendidos
- **Trámites recientes**: Últimos trámites ingresados
- **Accesos rápidos**: Enlaces a las funciones principales

### 4.2 Menú de Navegación

| Opción | Ruta | Descripción |
|--------|------|-------------|
| Dashboard | `/admin/tramites` | Panel principal con estadísticas |
| Lista de Trámites | `/admin/tramites/lista` | Ver todos los trámites con filtros |
| Nuevo Trámite | `/admin/tramites/nuevo` | Registrar trámite manualmente |
| Áreas | `/admin/tramites/areas` | Gestionar áreas de la institución |
| Tipos de Trámite | `/admin/tramites/tipos` | Configurar tipos de trámite |

---

## 5. Gestión de Áreas

### 5.1 ¿Qué son las Áreas?

Las áreas representan las dependencias o unidades orgánicas de la municipalidad que atienden los trámites.

### 5.2 Crear una Nueva Área

1. Vaya a **Trámites → Áreas**
2. Haga clic en **"Nueva Área"**
3. Complete los campos:

| Campo | Descripción | Obligatorio |
|-------|-------------|-------------|
| Nombre | Nombre del área (ej: Gerencia de Desarrollo Urbano) | Sí |
| Código | Código abreviado (ej: GDU) | Sí |
| Descripción | Descripción de funciones | No |
| Responsable | Nombre del jefe o responsable | No |
| Email | Correo institucional del área | No |
| Teléfono | Anexo o teléfono directo | No |
| Orden | Orden de aparición en listas | No |
| Activo | Si el área está operativa | Sí |

4. Haga clic en **"Guardar"**

### 5.3 Editar o Eliminar Áreas

- Use el botón **editar** (lápiz) para modificar
- Use el botón **eliminar** (papelera) para borrar (solo si no tiene trámites)

---

## 6. Gestión de Tipos de Trámite

### 6.1 ¿Qué son los Tipos de Trámite?

Los tipos de trámite definen las categorías de solicitudes que pueden realizar los ciudadanos, con sus requisitos, plazos y costos.

### 6.2 Crear un Nuevo Tipo de Trámite

1. Vaya a **Trámites → Tipos de Trámite**
2. Haga clic en **"Nuevo Tipo"**
3. Complete los campos:

| Campo | Descripción | Obligatorio |
|-------|-------------|-------------|
| Nombre | Nombre del trámite (ej: Licencia de Funcionamiento) | Sí |
| Código | Código único (ej: LIC-FUNC) | Sí |
| Descripción | Descripción detallada del trámite | No |
| Requisitos | Lista de documentos o requisitos necesarios | No |
| Área | Área responsable de atender este trámite | No |
| Plazo (días) | Días hábiles para resolver el trámite | Sí |
| Costo | Costo del trámite en soles (0 = gratuito) | Sí |
| Requiere Documentos | Si es obligatorio adjuntar documentos | No |
| Permite Seguimiento Online | Si el ciudadano puede ver el seguimiento | No |
| Activo | Si el tipo está disponible para nuevos trámites | Sí |

4. Haga clic en **"Guardar"**

---

## 7. Gestión de Trámites

### 7.1 Lista de Trámites

Acceda a `/admin/tramites/lista` para ver todos los trámites.

#### Tabs por Estado
La lista incluye pestañas para filtrar por estado:
- **Todos**: Muestra todos los trámites
- **Pendientes**: Esperando atención
- **En Proceso**: Siendo trabajados
- **Observados**: Con observaciones pendientes
- **Derivados**: Enviados a otra área
- **Atendidos**: Finalizados exitosamente
- **Archivados**: Casos cerrados
- **Rechazados**: Solicitudes rechazadas

#### Filtros Adicionales
- Búsqueda por expediente, DNI o nombre
- Filtro por tipo de trámite
- Filtro por área
- Filtro por prioridad

### 7.2 Ver Detalle de un Trámite

Haga clic en el botón **"Ver"** (ojo) para acceder a la ficha completa:

#### Pestañas de Información
| Pestaña | Contenido |
|---------|-----------|
| **Información** | Datos del solicitante y del trámite |
| **Trazabilidad** | Resumen visual del recorrido del documento |
| **Documentos** | Archivos adjuntos al expediente |
| **Historial Detallado** | Timeline completo de movimientos |

### 7.3 Acciones sobre un Trámite

Desde la ficha del trámite puede realizar:

| Acción | Descripción |
|--------|-------------|
| **Cambiar Estado** | Actualizar el estado del trámite |
| **Derivar** | Enviar el trámite a otra área |
| **Agregar Documento** | Adjuntar nuevos documentos |
| **Agregar Comentario** | Registrar observaciones internas |
| **Editar** | Modificar datos del trámite |

### 7.4 Cambiar Estado de un Trámite

1. En la ficha del trámite, busque la sección **"Acciones"**
2. Seleccione el nuevo estado
3. Agregue un comentario explicativo (opcional pero recomendado)
4. Haga clic en **"Actualizar Estado"**

### 7.5 Derivar un Trámite

1. Haga clic en **"Derivar"**
2. Seleccione el área destino
3. Ingrese las instrucciones o motivo de la derivación
4. Haga clic en **"Confirmar Derivación"**

El sistema registrará automáticamente:
- Fecha y hora de la derivación
- Usuario que realizó la acción
- Área de origen y destino
- Instrucciones

---

## 8. Seguimiento y Trazabilidad

### 8.1 Vista de Trazabilidad

La pestaña **"Trazabilidad"** muestra un resumen profesional del recorrido del documento:

#### Componentes
1. **Barra de Progreso**: Visualización del avance del trámite
2. **Tabla de Movimientos**: Resumen de cada acción realizada
3. **Áreas Visitadas**: Lista de áreas por donde pasó el documento
4. **Estadísticas Rápidas**: Días transcurridos, total de movimientos, etc.

### 8.2 Historial Detallado

La pestaña **"Historial Detallado"** muestra un timeline completo con:

- Fecha y hora exacta de cada acción
- Usuario responsable
- Tipo de acción realizada
- Comentarios y observaciones
- Área donde se realizó la acción

---

## 9. Estados del Trámite

### 9.1 Descripción de Estados

| Estado | Color | Descripción |
|--------|-------|-------------|
| **Pendiente** | 🟡 Amarillo | Trámite ingresado, esperando primera atención |
| **En Proceso** | 🔵 Azul | Trámite siendo trabajado por un funcionario |
| **Observado** | 🟣 Morado | Requiere subsanación o información adicional |
| **Derivado** | 🔷 Celeste | Enviado a otra área para su atención |
| **Atendido** | 🟢 Verde | Trámite finalizado satisfactoriamente |
| **Archivado** | ⚫ Gris | Expediente cerrado y archivado |
| **Rechazado** | 🔴 Rojo | Solicitud rechazada o improcedente |

### 9.2 Flujo Típico de Estados

```
[Pendiente] → [En Proceso] → [Derivado]* → [En Proceso] → [Atendido] → [Archivado]
                    ↓
              [Observado] → [En Proceso] (subsanación)
                    ↓
              [Rechazado]

* El trámite puede ser derivado múltiples veces entre áreas
```

### 9.3 Prioridades

| Prioridad | Color | Descripción |
|-----------|-------|-------------|
| **Baja** | 🔵 Azul | Atención normal |
| **Normal** | 🟢 Verde | Prioridad estándar |
| **Alta** | 🟡 Amarillo | Requiere atención preferente |
| **Urgente** | 🔴 Rojo | Atención inmediata requerida |

---

## 10. Reportes y Estadísticas

### 10.1 Dashboard de Estadísticas

El dashboard (`/admin/tramites`) muestra:

- **Total de trámites** en el sistema
- **Trámites pendientes** que requieren atención
- **Trámites en proceso** siendo trabajados
- **Trámites atendidos** finalizados
- **Trámites vencidos** que superaron su fecha límite

### 10.2 Indicadores de Gestión

| Indicador | Fórmula |
|-----------|---------|
| Tasa de Atención | (Atendidos / Total) × 100 |
| Tasa de Rechazo | (Rechazados / Total) × 100 |
| Tiempo Promedio | Suma días / Total atendidos |
| Trámites Vencidos | Fecha actual > Fecha límite |

---

## Anexos

### A. Formato de Número de Expediente

```
EXP-YYYY-NNNNNN

Donde:
- EXP: Prefijo fijo
- YYYY: Año de ingreso
- NNNNNN: Número correlativo de 6 dígitos
```

Ejemplo: `EXP-2025-000001`

### B. Código de Verificación

Código alfanumérico de 8 caracteres generado automáticamente para verificar la autenticidad de la consulta.

Ejemplo: `A1B2C3D4`

### C. Formatos de Archivo Permitidos

| Tipo | Extensiones | Tamaño Máximo |
|------|-------------|---------------|
| Documentos | PDF, DOC, DOCX | 5 MB |
| Imágenes | JPG, JPEG, PNG | 5 MB |
| Hojas de cálculo | XLS, XLSX | 5 MB |

### D. Contacto de Soporte

Para soporte técnico del sistema:
- **Email**: soporte@municipalidad.gob.pe
- **Teléfono**: (052) 480050
- **Horario**: Lunes a Viernes de 7:00 AM a 4:30 PM

---

## Historial de Versiones

| Versión | Fecha | Descripción |
|---------|-------|-------------|
| 1.0 | Diciembre 2025 | Versión inicial del manual |

---

**© 2025 Municipalidad - Subsistema de Trámite Documentario**

*Documento generado automáticamente*



