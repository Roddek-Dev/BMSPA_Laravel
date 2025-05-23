# 🎵 BarberMusic&Spa 💈💇‍♀️✨

<div align="center">
  <img src="https://i.imgur.com/your-logo-url-here.png" alt="Logo de BarberMusic&Spa" width="200"/> 
  <p><strong>SPA y Barbería con un Toque Musical 🎶</strong></p>
  
  <p>
    <a href="https://github.com/roddek-dev/bmspa_laravel/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
  </p>
  <p>
    <img src="https://img.shields.io/badge/Laravel-v12.x-FF2D20?style=flat-square&logo=laravel" alt="Laravel 12">
    <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php" alt="PHP 8.2+">
    <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql" alt="MySQL 8.0">
    <img src="https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=flat-square&logo=tailwindcss" alt="TailwindCSS 3.x">
    <img src="https://img.shields.io/badge/JWT-Auth-000000?style=flat-square&logo=jsonwebtokens" alt="JWT Auth">
  </p>
</div>

## 🚀 Demo en Vivo (Próximamente)

Visita nuestra aplicación: `Enlace a tu demo desplegada aquí` (¡Próximamente!)

## 🌟 Descripción General [cite: 8, 9]

**Music Barber & Spa** es una aplicación web integral diseñada para optimizar las operaciones diarias de una barbería/spa, mejorar la eficiencia en la administración de sus servicios y ventas, y enriquecer significativamente la experiencia de sus clientes a través de interacciones digitales ágiles y modernas[cite: 9]. La plataforma combina capacidades de reserva de citas, funcionalidad de comercio electrónico para productos y herramientas administrativas robustas para una gestión completa del negocio.

Nuestra propuesta única de valor es la integración de la música y la relajación en cada servicio, proporcionando una experiencia inigualable para nuestros clientes.

## ✨ Características Principales

El sistema "Music Barber & Spa" ofrecerá un conjunto integral de funcionalidades para satisfacer las necesidades tanto de los clientes como de los administradores[cite: 114].

### 💇‍♂️ Portal del Cliente

* **Gestión de Perfil y Autenticación** 👤: Registro, inicio de sesión (local y potencialmente OAuth2), recuperación de contraseña y gestión del perfil de usuario[cite: 12, 115].
* **Catálogo de Servicios y Productos** каталог: Visualización detallada de servicios (cortes, masajes, etc.) y productos de cuidado personal disponibles[cite: 13, 116].
* **Agendamiento de Citas Online** 📅: Reserva fácil de servicios, seleccionando sucursal, servicio, fecha y hora según disponibilidad[cite: 14, 117].
* **Tienda de Productos Online** 🛍️: Carrito de compras para seleccionar productos, gestionar pedidos y finalizar compras[cite: 15, 118].
* **Procesamiento de Pagos Seguro** 💳: Integración con pasarelas de pago (ej. PayPal, MercadoPago) para transacciones seguras[cite: 16, 118].
* **Historial de Órdenes y Citas** 📜: Consulta del historial de compras de productos y citas agendadas[cite: 17].
* **Localizador de Sucursales** 📍: Encuentra la sucursal más cercana con información detallada.

### 💼 Panel de Administración (DDD Contexts)

El panel de administración proporciona una interfaz centralizada para la gestión completa del negocio, organizada bajo una arquitectura de Diseño Orientado al Dominio (DDD)[cite: 20, 120].

* **Contexto `Admin`**:
    * Gestión de Personal (`personal`): Administración de empleados, roles y asignaciones a sucursales.
    * Gestión de Sucursales (`sucursales`): Creación y mantenimiento de la información de las diferentes sucursales[cite: 18].
    * Gestión de Categorías (`categorias`): Administración de categorías para productos y servicios.
    * Gestión de Especialidades (`especialidades`): Definición de especialidades del personal.
    * Gestión de Promociones (`promociones`): Creación y administración de ofertas y descuentos.
    * Configuración de Recordatorios (`recordatorios`): Gestión de plantillas y reglas para notificaciones[cite: 19].
* **Contexto `Client`**:
    * Gestión de Usuarios (`usuarios`): Administración de cuentas de clientes y administradores.
    * Gestión de Órdenes (`ordenes`, `detalle_ordenes`): Seguimiento y administración de pedidos de productos.
    * Gestión de Reseñas (`reseñas`): Moderación y visualización de opiniones de clientes.
    * Preferencias Musicales (`musica_preferencias_navegacion`): Gestión de opciones de música para clientes.
* **Contexto `Scheduling`**:
    * Gestión de Agendamientos (`agendamientos`): Supervisión, modificación y cancelación de citas.
    * Gestión de Horarios (`horarios_sucursal`, `excepciones_horario_sucursal`): Configuración de horarios de atención por sucursal y manejo de excepciones.
* **Contexto `Catalog`**:
    * Gestión de Productos (`productos`): Administración del inventario de productos, precios, descripciones e imágenes[cite: 120].
    * Gestión de Servicios (`servicios`): Definición y mantenimiento de los servicios ofrecidos, duraciones y precios[cite: 120].
* **Contexto `Payments`**:
    * Gestión de Transacciones (`transacciones_pago`): Seguimiento de los pagos realizados a través de las pasarelas.

## 🛠️ Detalles Técnicos

BarberMusic&Spa está construido con un stack tecnológico moderno y robusto:

* **Backend**: Laravel 12.x (PHP 8.2+) siguiendo una arquitectura de Diseño Orientado al Dominio (DDD).
* **Frontend**: Blade (motor de plantillas de Laravel), TailwindCSS, Vite.js para la compilación de assets.
* **Base de Datos**: MySQL (compatible, con migraciones para la estructura).
* **Autenticación API**: JWT (JSON Web Tokens) mediante el paquete `php-open-source-saver/jwt-auth`.
* **Seguridad**: Acceso basado en roles (`CLIENTE`, `EMPLEADO`, `ADMIN_GENERAL`, `ADMIN_SUCURSAL`) utilizando middleware personalizado.
* **APIs Externas (Previstas)**: Integración con PayPal y MercadoPago para procesamiento de pagos.
* **Notificaciones**: Sistema de correo electrónico para recordatorios y confirmaciones[cite: 170].

## 📋 Requisitos del Sistema

* PHP 8.2 o superior.
* Composer.
* Node.js y NPM (o Yarn) para la gestión de assets de frontend.
* Servidor de base de datos compatible con Laravel (MySQL 8.0+ recomendado).
* Servidor web (Nginx o Apache recomendado para producción).

## 🚀 Instalación y Configuración

Sigue estos pasos para instalar y configurar el proyecto localmente:

1.  **Clonar el repositorio**:
    ```bash
    git clone https://github.com/tu-usuario/BMSPA_Laravel.git
    cd BMSPA_Laravel
    ```

2.  **Instalar dependencias de PHP**:
    ```bash
    composer install
    ```

3.  **Instalar dependencias de Node.js**:
    ```bash
    npm install
    # o si usas yarn:
    # yarn install
    ```

4.  **Configurar el entorno**:
    * Copia el archivo de ejemplo `.env.example` a `.env`:
        ```bash
        cp .env.example .env
        ```
    * Genera la clave de la aplicación:
        ```bash
        php artisan key:generate
        ```
    * Configura las variables de entorno en tu archivo `.env`, especialmente:
        * `APP_NAME`, `APP_URL`
        * Conexión a la base de datos (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
        * Credenciales de servicios de correo (`MAIL_MAILER`, `MAIL_HOST`, etc.)
        * Genera el secreto para JWT:
            ```bash
            php artisan jwt:secret
            ```
            Y asegúrate que `JWT_SECRET` esté en tu `.env`.

5.  **Ejecutar las migraciones y seeders (opcional)**:
    * Esto creará la estructura de la base de datos.
        ```bash
        php artisan migrate
        ```
    * Si tienes seeders para datos iniciales:
        ```bash
        php artisan db:seed
        ```

6.  **Compilar assets de frontend**:
    * Para desarrollo (con hot reloading):
        ```bash
        npm run dev
        ```
    * Para producción:
        ```bash
        npm run build
        ```

7.  **Servir la aplicación**:
    ```bash
    php artisan serve
    ```
    La aplicación estará disponible generalmente en `http://localhost:8000`.

## 📸 Capturas de Pantalla (Ejemplos)

<div align="center">
  <img src="[https://i.imgur.com/screenshot1.png](https://i.imgur.com/screenshot1.png)" alt="Página Principal" width="300"/>
  <img src="[https://i.imgur.com/screenshot2.png](https://i.imgur.com/screenshot2.png)" alt="Panel de Administración" width="300"/>
  <br>
  <img src="[https://i.imgur.com/screenshot3.png](https://i.imgur.com/screenshot3.png)" alt="Sistema de Reservas" width="300"/>
  <img src="[https://i.imgur.com/screenshot4.png](https://i.imgur.com/screenshot4.png)" alt="Tienda de Productos" width="300"/>
  <p><em>Nota: Reemplaza estas URLs con capturas reales de tu aplicación Laravel.</em></p>
</div>

## 📂 Estructura del Proyecto (DDD)

El proyecto sigue una arquitectura de Diseño Orientado al Dominio (DDD) organizada en contextos y capas:

## 📂 Estructura del Proyecto (DDD)

El proyecto sigue una arquitectura de Diseño Orientado al Dominio (DDD) organizada en contextos y capas:

src/
├── Admin/                 # Contexto para funcionalidades administrativas generales
│   ├── categorias/
│   ├── especialidades/
│   ├── personal/
│   ├── promociones/
│   ├── recordatorios/
│   └── sucursales/
├── Catalog/               # Contexto para el catálogo de productos y servicios
│   ├── productos/
│   └── servicios/
├── Client/                # Contexto para funcionalidades orientadas al cliente
│   ├── detalle_ordenes/
│   ├── musica_preferencias_navegacion/
│   ├── ordenes/
│   ├── reseñas/
│   └── usuarios/          # Incluye Autenticación y Gestión de Perfil
├── Payments/              # Contexto para la gestión de pagos
│   └── transacciones_pago/
└── Scheduling/            # Contexto para agendamientos y horarios
├── agendamientos/
├── excepciones_horario_sucursal/
└── horarios_sucursal/

Dentro de cada módulo (ej. src/Client/usuarios/):
├── application/       # Casos de uso, DTOs, Handlers/Services de aplicación
├── domain/            # Entidades, Value Objects, Repositories (interfaces), Domain Services
└── infrastructure/    # Implementaciones (Controllers, Eloquent Repositories, Providers, Rutas API)
Adicionalmente, la estructura estándar de Laravel (`app/`, `config/`, `database/`, `routes/`, etc.) complementa la organización del código fuente en `src/`. Se utiliza un comando Artisan personalizado `make:ddd` para generar la estructura base de los módulos DDD.

## 🗃️ Modelo de Base de Datos (Entidades Principales)

La aplicación utiliza las siguientes tablas principales, gestionadas mediante migraciones de Laravel:

* **`usuarios`**: Información de clientes y administradores, roles, preferencias.
* **`personal`**: Detalles del personal (empleados), sucursal asignada, tipo.
* **`sucursales`**: Información de las diferentes ubicaciones del negocio.
* **`servicios`**: Catálogo de servicios ofrecidos (cortes, masajes, etc.).
* **`productos`**: Catálogo de productos para la venta.
* **`categorias`**: Para organizar productos y servicios.
* **`especialidades`**: Especialidades que puede tener el personal.
* **`agendamientos`**: Reservas de citas de clientes para servicios en sucursales.
* **`ordenes`**: Pedidos de productos realizados por los clientes.
* **`detalle_ordenes`**: Artículos individuales dentro de cada orden.
* **`promociones`**: Códigos de descuento y ofertas especiales.
* **`horarios_sucursal`**: Horarios regulares de atención por día de la semana para cada sucursal.
* **`excepciones_horario_sucursal`**: Días festivos o cierres especiales.
* **`recordatorios`**: Para gestionar notificaciones de citas.
* **`reseñas`**: Opiniones de los clientes sobre servicios o productos.
* **`transacciones_pago`**: Registro de las transacciones procesadas.
* Y tablas pivot para relaciones muchos a muchos (ej. `especialidad_personal`, `promocion_servicio`, `producto_promocion`, `servicio_personal`, `servicio_sucursal`).

## 🎭 Roles y Permisos

El sistema define los siguientes roles de usuario:

* **`CLIENTE`**: Puede registrarse, iniciar sesión, ver catálogo, agendar citas, comprar productos, gestionar su perfil y ver su historial.
* **`EMPLEADO`**: (Alcance a definir, podría incluir gestión de sus propias citas o perfil profesional).
* **`ADMIN_SUCURSAL`**: (Alcance a definir, podría gestionar operaciones específicas de una sucursal).
* **`ADMIN_GENERAL`**: Acceso completo a todas las funcionalidades de administración del sistema.

El acceso a las rutas API está protegido por el guard `auth:api` (JWT) y el middleware `role:{rol}` para funcionalidades específicas.

## 👨‍💻 Equipo de Desarrollo (Según SRS) [cite: 22, 23, 24, 25]

* Rody Esteban Ávila Bohórquez - Analista, Diseñador y Programador [cite: 22]
* Carlos Estiven Rodríguez Niño - Analista, Diseñador y Programador [cite: 23]
* Daniel Esteban Ortiz Pinzón - Analista, Diseñador y Programador [cite: 24]
* Daniel Armando Gómez Chaparro - Analista, Diseñador y Programador [cite: 25]

## 📜 Licencia

Este proyecto está licenciado bajo la Licencia MIT. Ver el archivo `LICENSE` (o referenciar la licencia MIT estándar de Laravel).

## 📧 Contacto

Para consultas o soporte, por favor contáctanos en: `catcomarketing@gmail.com`

---

<div align="center">
  <p>© BarberMusic&Spa - Experiencia Premium en Spa y Barbería</p>
  <p>🎵 Donde el estilo se encuentra con la relajación 💈</p>
</div>
