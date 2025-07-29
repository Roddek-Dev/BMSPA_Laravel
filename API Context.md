# Archivo de Contexto Maestro v3.0: BarberMusic&Spa (API Backend)

## 1. Visión y Objetivo del Proyecto

- **Nombre del Proyecto:** BarberMusic&Spa (BMSPA)
- **Objetivo:** Desarrollar el backend (API) para un ecosistema de dos aplicaciones (App de Cliente y Panel de Admin) que gestionan las operaciones de una cadena de barberías y spas con múltiples sucursales en México.
- **Principios Clave:**
    - **Experiencia Premium al Cliente:** La app de cliente debe ser intuitiva, facilitando el agendamiento y la compra de productos.
    - **Gestión Centralizada y Eficiente:** El panel de admin debe ser una herramienta robusta para que los gerentes y administradores de sucursal gestionen todas las operaciones sin fricción.
    - **Arquitectura Robusta:** El backend se construye sobre una **Arquitectura Hexagonal (DDD)**, separando estrictamente la lógica de negocio del framework para garantizar mantenibilidad y escalabilidad.

---

## 2. Los Actores: Roles y Permisos

El sistema se rige por 4 roles con una jerarquía clara. El acceso a las funcionalidades de la API está estrictamente controlado por estos roles.

| Rol | Descripción | Permisos Clave en la API |
| :--- | :--- | :--- |
| **Cliente** | Rol por defecto para cualquier usuario registrado. | - Gestionar su propio perfil y su única dirección predeterminada.<br>- Crear y gestionar sus propias citas (agendamientos).<br>- Crear y ver el historial de sus propias órdenes de productos.<br>- Crear, editar y eliminar sus propias reseñas (`reseñas`). |
| **Empleado** | Personal operativo (barberos, estilistas). | - Consultar su agenda de citas asignadas.<br>- Cambiar el estado de sus citas (ej. a `COMPLETADA` o `CANCELADA_PERSONAL`).<br>- Consultar el catálogo de servicios y productos. |
| **Admin Sucursal** | Administrador de una única sucursal. | - Hereda permisos de **Empleado**.<br>- **Gestión de Catálogo (SU sucursal):** CRUD de servicios y productos y su disponibilidad en su sucursal.<br>- **Gestión de Personal (SU sucursal):** Promover un **Cliente** a **Empleado**, asignándolo automáticamente a su sucursal.<br>- **Gestión de Operaciones:** CRUD de `horarios_sucursal`, ver todos los agendamientos de su sucursal.<br>- **Moderación de Reseñas:** Aprobar/Rechazar las reseñas de su sucursal. |
| **Gerente (Super Admin)** | Máxima autoridad con acceso global. | - Hereda todos los permisos inferiores.<br>- **Gestión Global:** CRUD completo de `Sucursales`, `Categorías`, `Promociones`, `Especialidades`.<br>- **Gestión de Personal Global:** Promover un **Empleado** a **Admin Sucursal**.<br>- Acceso sin restricciones a todos los datos de todas las sucursales.<br>- Exportar a Hojas de cálculo. |

---

## 3. Aplicación 1: App de Cliente (Flujo y Lógica de Negocio)

**Propósito:** La interfaz principal para el público. Su lógica debe ser fluida y centrada en la facilidad de uso.

### Autenticación y Perfil:
- Un usuario se registra y obtiene el rol **CLIENTE**.
- El cliente gestiona una **única dirección predeterminada**. El concepto de múltiples direcciones se descarta.
- Las preferencias de música y sucursal se descartan de la lógica de negocio por ahora.

### Flujo de Agendamiento de Citas (Lógica Crítica):
1.  **Exploración:** El usuario ve la lista de servicios y los puede filtrar por categoría.
2.  **Selección de Servicio:** El usuario elige un **único servicio** por agendamiento.
3.  **Selección de Sucursal:** El usuario elige una sucursal. La app puede sugerir la más cercana o la última visitada.
4.  **Pre-validación de Disponibilidad:** Antes de mostrar el calendario, la API debe realizar una consulta rápida para verificar si hay huecos disponibles para ese servicio en esa sucursal, informando al usuario si no es posible agendar.
5.  **Selección de Fecha y Hora:** Se muestra un calendario con los `horarios_sucursal` disponibles.
6.  **Selección de Personal (Opcional):** El cliente puede seleccionar un miembro del personal de su preferencia. Esto se guarda como una solicitud. El agendamiento se crea, pero el administrador debe confirmarlo.
7.  **Confirmación:** Se crea el agendamiento con estado `PROGRAMADA`.
8.  **Pago:** **No se realiza pago online para las citas**. El pago se efectúa en la sucursal. La tabla `transacciones_pago` NO se usa para agendamientos.

### Gestión de Órdenes de Productos:
- **Creación de Orden:** El cliente crea una orden que contiene un array de `detalle_ordenes`.
- **Pago Online:** El pago de las órdenes de productos se realiza a través de **PayPal y MercadoPago**. Una vez completado el pago, se crea un registro en la tabla `transacciones_pago` vinculado a la orden, y el estado de la orden cambia a `PAGADA`.

### Gestión de Reseñas:
- **Creación:** Un cliente puede crear una reseña para un servicio o sucursal. Se guarda con `aprobada = false` (pendiente de moderación).
- **Edición:** Un cliente puede editar el texto y la calificación de una reseña que ya ha escrito. Al editarla, su estado debe volver a `aprobada = false` para requerir una nueva moderación por parte del administrador.
- **Eliminación:** Un cliente puede eliminar su propia reseña en cualquier momento, y la eliminación es permanente en la base de datos.

---

## 4. Aplicación 2: Panel de Administración (Flujo y Lógica de Negocio)

**Propósito:** La herramienta interna para la gestión del negocio, con una lógica basada en roles y eficiencia.

### Dashboard:
- Presenta métricas relevantes para el rol (un **Admin Sucursal** solo ve datos de su sucursal, un **Gerente** ve datos globales).

### Gestión de Personal (Lógica de "Promoción"):
- El CRUD de personal no es un formulario tradicional.
- **Promover a Empleado (Admin Sucursal):**
    - El admin ve una lista de usuarios con `rol = CLIENTE`.
    - Al hacer clic en "Promover" en un usuario, la API debe:
        a. Cambiar el rol del usuario a `EMPLEADO`.
        b. Crear un nuevo registro en la tabla `personal`, vinculándolo al `usuario_id` y asignando automáticamente el `sucursal_asignada_id` del administrador que realiza la acción.
- **Promover a Admin de Sucursal (Gerente):**
    - El gerente ve una lista de usuarios con `rol = EMPLEADO`.
    - Al hacer clic en "Promover a Admin", la API debe cambiar el `tipo_personal` en la tabla `personal` a `ADMIN_SUCURSAL`.

### Gestión de Agendamientos:
- Un **Admin Sucursal** ve todas las citas de su sucursal.
- Si una cita tiene una solicitud de personal específico, el admin debe poder confirmar o reasignar a otro miembro del personal disponible, y luego cambiar el estado de la cita a `CONFIRMADA`.

### Moderación de Reseñas:
- El **Admin Sucursal** ve una lista de reseñas de su sucursal con `aprobada = false`.
- Tiene dos acciones: "Aprobar" (cambia `aprobada` a `true`, haciéndola visible públicamente) o "Rechazar" (la reseña puede ser eliminada o marcada como rechazada).

---

## 5. Reglas de Negocio Críticas y Lógica Transversal

### Pagos:
- **Citas:** Se pagan 100% en la sucursal. No hay lógica de pago online.
- **Productos:** Se pagan 100% online vía PayPal/MercadoPago. Cada orden pagada debe tener su `transaccion_pago` correspondiente.

### Notificaciones:
- **Canales:** Email y Notificaciones Push dentro de la app.
- **Eventos a Notificar:**
    - **Recordatorios de Citas:** Enviar un recordatorio (ej. 24h y 2h antes) de un agendamiento al `cliente_usuario_id`.
    - **Confirmación/Cambio de Cita:** Notificar al cliente si su cita es confirmada o si el personal asignado ha cambiado.
    - **Detalles de Orden:** Enviar un email de confirmación con los `detalle_ordenes` después de una compra exitosa.

### Reportes:
- Funcionalidad no requerida en esta fase del proyecto.