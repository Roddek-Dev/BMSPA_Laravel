# Archivo de Contexto Maestro v3.0: App de Cliente (Flutter)

## 1. Visión y Objetivo de la Aplicación

- **Nombre de la App:** BarberMusic&Spa (BMSPA)
- **Plataforma:** `Flutter` (para dispositivos móviles iOS y Android).
- **Objetivo:** Ofrecer a los clientes de BarberMusic&Spa una experiencia premium, moderna y sin fricciones para interactuar con la marca. La app debe permitirles descubrir servicios, agendar citas con facilidad, comprar productos y gestionar su perfil y su historial con la barbería.
- **Principios de Desarrollo:**
    - **Interfaz Intuitiva y Atractiva:** El diseño debe ser limpio, moderno y fácil de navegar, reflejando la calidad de la marca.
    - **Rendimiento Fluido:** La aplicación debe ser rápida y responsiva, manejando estados de carga y errores de forma elegante para no frustrar al usuario.
    - **Interacción Segura con la API:** Todas las comunicaciones con el backend deben ser seguras, utilizando el token JWT obtenido durante la autenticación.
    - **Gestión de Estado Eficiente:** Utilizar un manejador de estado robusto (como `Provider`, `BLoC/Cubit`, o `Riverpod`) para gestionar los datos del usuario, el catálogo, las citas y el estado de la UI.

---

## 2. Estructura General y Navegación (Flujo Principal)

La aplicación se organizará en torno a una barra de navegación inferior (un `BottomNavigationBar`) con las siguientes secciones principales:

- **Inicio:** Pantalla principal con acceso rápido a las acciones más comunes.
- **Agendar:** El flujo principal para reservar una cita.
- **Tienda:** Catálogo de productos para comprar.
- **Mis Citas:** Historial de citas pasadas y futuras.
- **Perfil:** Gestión de la cuenta del usuario.

---

## 3. Detalle de Módulos y Pantallas

### Módulo 1: Autenticación (Onboarding)

#### Pantalla de Bienvenida/Login/Registro:
- **UI:** Un flujo limpio, posiblemente con un `PageView`, que permite al usuario iniciar sesión o registrarse. Campos para nombre, email, contraseña y teléfono.
- **Estado:** `isLoading` durante las llamadas a la API, manejo de mensajes de error (ej. "El correo ya existe", "Credenciales incorrectas").
- **API Calls:**
    - `POST /api/Client_usuarios/auth/register`
    - `POST /api/Client_usuarios/auth/login`
- **Lógica:** Tras un login/registro exitoso, el token JWT y los datos del usuario se guardan de forma segura en el dispositivo (usando `flutter_secure_storage`) y se navega al HomeScreen.

### Módulo 2: Inicio

#### Pantalla de Inicio (HomeScreen):
- **UI:** Un dashboard atractivo que muestra:
    - Un saludo personalizado al usuario.
    - Un botón grande y visible para "Agendar Nueva Cita".
    - Un carrusel o sección destacando promociones activas.
    - Una sección de "Servicios Populares".
- **Estado:** `isLoading` mientras se cargan los datos, listas de promociones y servicios.
- **API Calls:** `GET /api/Admin_promociones/promociones`, `GET /api/Catalog_servicios/servicios`.

### Módulo 3: Flujo de Agendamiento de Citas
Este es el corazón de la aplicación y debe ser un flujo guiado (un "wizard" o `Stepper`).

#### Pantalla 1: Selección de Servicio:
- **UI:** Lista de servicios agrupados por categoría. Cada servicio muestra su nombre, descripción, duración y precio. Un buscador para filtrar por nombre.
- **Lógica:** El usuario puede seleccionar un **único servicio**.
- **API Calls:** `GET /api/Catalog_servicios/servicios`, `GET /api/Admin_categorias/categorias`.

#### Pantalla 2: Selección de Sucursal:
- **UI:** Lista de sucursales disponibles, idealmente mostradas en un mapa y/o en una lista ordenada por cercanía.
- **API Calls:** `GET /api/Admin_sucursales/sucursales`.

#### Pantalla 3: Selección de Fecha y Hora:
- **UI:** Un calendario para elegir el día. Debajo, una grilla con los horarios (slots) disponibles para ese día en la sucursal seleccionada.
- **Lógica de Negocio (Crítica):** Antes de mostrar los horarios, la app debe hacer una llamada de pre-validación a la API para obtener solo los slots disponibles, considerando la duración del servicio seleccionado.
- **API Calls:** `GET /api/disponibilidad?servicio_id=X&sucursal_id=Y&fecha=YYYY-MM-DD` (endpoint sugerido que el backend debería tener).

#### Pantalla 4: Selección de Personal (Opcional):
- **UI:** Lista del personal disponible para el servicio, sucursal y horario seleccionados. Incluye una opción "Cualquiera".
- **Lógica:** La selección de un personal específico es una solicitud.
- **API Calls:** `GET /api/disponibilidad/personal?servicio_id=X&sucursal_id=Y&fecha_hora=...` (endpoint sugerido).

#### Pantalla 5: Resumen y Confirmación:
- **UI:** Muestra todos los detalles de la cita (servicio, sucursal, fecha, hora, personal solicitado, precio final). Un campo para `notas_cliente`. Un botón para "Confirmar Cita".
- **Lógica:** Al confirmar, se empaquetan todos los datos y se envían a la API. Se maneja el estado de carga y se muestra un mensaje de éxito o error.
- **Pago:** Se le informa al usuario que "El pago se realizará en la sucursal".
- **API Calls:** `POST /api/Scheduling_agendamientos/agendamientos`.

### Módulo 4: Tienda

#### Pantalla de Catálogo de Productos:
- **UI:** Una grilla de productos con imagen, nombre, precio y un botón de "Añadir al Carrito". Filtros por categoría.
- **Estado:** Lista de productos, estado del carrito de compras (manejado localmente o en el estado global).
- **API Calls:** `GET /api/Catalog_productos/productos`.

#### Pantalla de Carrito de Compras:
- **UI:** Lista de productos en el carrito, con opción de cambiar la cantidad. Muestra subtotal, impuestos y total. Botón para "Proceder al Pago".

#### Pantalla de Checkout y Pago:
- **UI:** Pide al usuario que confirme su única dirección de envío. Muestra los métodos de pago.
- **Lógica:** Integra los SDKs de **PayPal** y **MercadoPago** para procesar el pago.
- **API Calls:**
    - Al iniciar el pago, se puede llamar a la API para crear la orden con estado `PENDIENTE_PAGO`.
    - Tras un pago exitoso, se notifica a la API para que actualice el estado a `PAGADA` y cree la `transaccion_pago`. `POST /api/Client_ordenes/ordenes`.

### Módulo 5: Mis Citas y Mis Órdenes

#### Pantalla de "Mis Citas":
- **UI:** Dos pestañas: "Próximas" y "Anteriores". Cada cita es una tarjeta con la información clave.
- **Lógica:** Las citas próximas tienen un botón para "Cancelar". Las citas pasadas tienen un botón para "Dejar Reseña".
- **API Calls:** `GET /api/Scheduling_agendamientos/agendamientos` (la API debe filtrar por el `cliente_usuario_id` del token). `PUT .../{id}` para cancelar.

#### Pantalla de "Mis Órdenes":
- **UI:** Una lista del historial de ordenes, mostrando número de orden, fecha, total y estado.
- **API Calls:** `GET /api/Client_ordenes/ordenes`.

### Módulo 6: Perfil

#### Pantalla de Perfil:
- **UI:** Muestra la información del usuario. Opciones para navegar a:
    - "Editar Perfil"
    - "Mi Dirección"
    - "Mis Reseñas"
    - "Cerrar Sesión"
- **Lógica:** "Cerrar Sesión" debe limpiar el token guardado y navegar de vuelta a la pantalla de Login.
- **API Calls:** `POST /api/Client_usuarios/auth/logout`.