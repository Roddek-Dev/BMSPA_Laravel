# Archivo de Contexto Maestro v3.0: App de Administración (React Native)

## 1. Visión y Objetivo de la Aplicación

- **Nombre de la App:** Panel de Administración BMSPA
- **Plataforma:** `React Native` (para dispositivos móviles iOS y Android)
- **Objetivo:** Crear una herramienta móvil, potente y eficiente para que los **Gerentes** y **Administradores de Sucursal** gestionen todas las operaciones del negocio desde cualquier lugar. La app debe ser rápida, segura y presentar la información de forma clara y accionable.
- **Principios de Desarrollo:**
    - **Interfaz Orientada a Tareas:** Cada pantalla debe estar diseñada para completar tareas específicas de manera rápida (ej. aprobar una reseña, ver la agenda, promover un empleado).
    - **Consumo Eficiente de la API:** La app debe interactuar con el backend de forma optimizada, manejando estados de carga, errores y datos cacheados para una experiencia fluida.
    - **Seguridad Basada en Roles:** La UI debe adaptarse dinámicamente para mostrar/ocultar funcionalidades según el rol del usuario autenticado (**GERENTE** vs. **ADMIN_SUCURSAL**).

---

## 2. Estructura General y Navegación

La aplicación se estructurará en torno a un menú de navegación principal (probablemente un `Tab Navigator` o un `Drawer Navigator`) que dará acceso a los módulos clave.

- Dashboard / Inicio
- Agenda (Gestión de agendamientos)
- Catálogo (Gestión de servicios y productos)
- Personal (Gestión de personal)
- Clientes (Consulta de usuarios rol Cliente)
- Reseñas (Moderación)
- Configuración (Módulos solo para **GERENTE**)

---

## 3. Detalle de Módulos y Pantallas

### Módulo 1: Autenticación

#### Pantalla de Login:
- **UI:** Campos para email y contraseña. Botón de "Iniciar Sesión".
- **Estado:** Manejo de estado de carga (`isLoading`), errores de autenticación.
- **API Call:** `POST /api/Client_usuarios/auth/login`. Al tener éxito, guardar el token JWT de forma segura en el almacenamiento del dispositivo y el rol del usuario en el estado global.

### Módulo 2: Dashboard / Inicio

#### Pantalla Principal:
- **UI:** Tarjetas de resumen con métricas clave: "Citas para Hoy", "Ingresos del Día", "Reseñas Pendientes".
- **Lógica:** Al cargar, la app realiza varias llamadas a la API para obtener estos datos. Si el rol es **ADMIN_SUCURSAL**, todas las llamadas deben incluir un filtro por su sucursal asignada. Si es **GERENTE**, se muestran datos globales.
- **API Calls:**
    - `GET /api/Scheduling_agendamientos/agendamientos?fecha=hoy&sucursal_id=X`
    - `GET /api/Client_reseñas/reseñas?estado=PENDIENTE&sucursal_id=X`

### Módulo 3: Agenda

#### Pantalla de Agenda:
- **UI:** Vista de calendario (día/semana). Lista de citas para el día seleccionado, mostrando hora, nombre del cliente, servicio y personal asignado. Filtros para ver por miembro del personal.
- **Estado:** Manejo de la fecha seleccionada, lista de citas, estado de carga.
- **Lógica:** Al seleccionar un día, se llama a la API para traer los agendamientos de esa fecha y sucursal.
- **Interacción:** Al tocar una cita, se navega a la pantalla de "Detalle de Cita".
- **API Calls:** `GET /api/Scheduling_agendamientos/agendamientos?fecha=YYYY-MM-DD`

#### Pantalla de Detalle de Cita:
- **UI:** Muestra toda la información del agendamiento. Secciones claras para datos del cliente, servicio y notas. Botones de acción.
- **Lógica de Negocio (Crítica):**
    - Si la cita tiene una solicitud de personal (`personal_id` no es nulo), el admin debe ver botones para "Confirmar Asignación" o "Reasignar Personal".
    - El admin puede cambiar el estado de la cita (ej. a `COMPLETADA`, `CANCELADA_PERSONAL`).
- **API Calls:**
    - `GET /api/Scheduling_agendamientos/agendamientos/{id}`
    - `PUT /api/Scheduling_agendamientos/agendamientos/{id}` (para actualizar el estado o `personal_id`).

### Módulo 4: Catálogo

#### Pantalla de Lista de Servicios y Productos:
- **UI:** Dos pestañas: "Servicios" y "Productos". Cada una muestra una lista con el nombre, precio y estado (activo/inactivo). Botón flotante para añadir uno nuevo.
- **API Calls:** `GET /api/Catalog_servicios/servicios`, `GET /api/Catalog_productos/productos`

#### Pantalla de Crear/Editar (Servicio o Producto):
- **UI:** Un formulario con todos los campos necesarios (nombre, descripcion, precio, stock, etc.). Selector para la categoría. Toggle para activo.
- **API Calls:** `POST` o `PUT` al endpoint correspondiente (`/servicios` o `/productos`).

### Módulo 5: Gestión de Personal

#### Pantalla de Lista de Clientes (para Promoción):
- **UI:** Una lista de usuarios con `rol = CLIENTE`. Cada item muestra nombre y email. Al lado de cada uno, un botón de "Promover a Empleado".
- **Lógica de Negocio (Crítica):**
    - Esta pantalla es exclusiva para **ADMIN_SUCURSAL**.
    - Al presionar "Promover", la app debe mostrar un diálogo de confirmación.
    - Al confirmar, se realiza la llamada a la API que se encarga de cambiar el rol y crear el registro en `personal`, asignándolo a la sucursal del admin actual.
- **API Calls:** `GET /api/Client_usuarios/usuarios?rol=CLIENTE`, `POST /api/Admin_personal/promover-a-empleado` (endpoint sugerido que encapsula la lógica).

#### Pantalla de Lista de Empleados (para Gerente):
- **UI:** (Solo **GERENTE**) Una lista de personal con `tipo_personal` que no sea `ADMIN_SUCURSAL`. Botón para "Promover a Admin".
- **Lógica:** Similar a la anterior, pero para ascender a empleados.
- **API Calls:** `GET /api/Admin_personal/personal`, `PUT /api/Admin_personal/{id}/promover-a-admin` (endpoint sugerido).

### Módulo 6: Moderación de Reseñas

#### Pantalla de Reseñas Pendientes:
- **UI:** Una lista de tarjetas. Cada tarjeta muestra la calificación (estrellas), el comentario, el nombre del cliente y a qué (servicio o sucursal) se refiere la reseña. Dos botones en cada tarjeta: "Aprobar" y "Rechazar".
- **Lógica:**
    - La lista se obtiene de la API filtrando por `aprobada = false`.
    - "Aprobar" cambia el campo `aprobada` a `true`.
    - "Rechazar" podría eliminar la reseña o cambiarla a un estado `RECHAZADA`.
- **API Calls:** `GET /api/Client_reseñas/reseñas?aprobada=false`, `PUT /api/Client_reseñas/reseñas/{id}/moderar` (endpoint sugerido).

### Módulo 7: Configuración (Solo Gerente)

#### Pantalla de Configuración:
- **UI:** Un menú simple con opciones para navegar a:
    - Gestión de Sucursales
    - Gestión de Categorías
    - Gestión de Especialidades
    - Gestión de Promociones
- **Lógica:** Cada opción lleva a su respectivo CRUD, que consiste en una pantalla de lista y una pantalla de formulario (crear/editar).
- **API Calls:** Usará todos los endpoints de los CRUDs correspondientes (`/sucursales`, `/categorias`, `/especialidades`, `/promociones`).