# 🎵 BarberMusic&Spa (API Backend) 💈✨

<div align="center">
  <img src="https://i.imgur.com/your-logo-url-here.png" alt="Logo de BarberMusic&Spa" width="200"/>
  <h3><i>Donde el Estilo se Encuentra con la Relajación</i></h3>
  
  <p>
    <!-- Nota: Reemplaza 'roddek-dev/bmspa_laravel' con tu repositorio real para activar los badges -->
    <a href="https://github.com/roddek-dev/bmspa_laravel/actions/workflows/laravel.yml"><img src="https://github.com/roddek-dev/bmspa_laravel/actions/workflows/laravel.yml/badge.svg" alt="Build Status"></a>
    <a href="https://github.com/roddek-dev/bmspa_laravel/blob/main/LICENSE"><img src="https://img.shields.io/github/license/roddek-dev/bmspa_laravel" alt="License"></a>
    <a href="https://github.com/roddek-dev/bmspa_laravel/commits/main"><img src="https://img.shields.io/github/last-commit/roddek-dev/bmspa_laravel" alt="Last Commit"></a>
  </p>
  <p>
    <img src="https://img.shields.io/badge/Laravel-v11.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 11">
    <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php" alt="PHP 8.2+">
    <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql" alt="MySQL 8.0">
    <img src="https://img.shields.io/badge/Autenticación-OAuth2-000000?style=for-the-badge&logo=oauth" alt="OAuth2 Auth">
  </p>
</div>

## 🌟 Visión General

**BarberMusic&Spa (BMSPA)** es el **backend (API)** de un ecosistema de aplicaciones diseñado para gestionar las operaciones de una cadena de barberías y spas de lujo. Este proyecto se centra en dos principios clave: ofrecer una **experiencia premium al cliente** y proporcionar una **herramienta de gestión centralizada y eficiente** para los administradores.

Construido sobre una **Arquitectura Hexagonal (DDD)**, el backend separa estrictamente la lógica de negocio del framework para garantizar una alta mantenibilidad y escalabilidad a futuro.

## ✨ Características Principales

### 💇‍♂️ Para Clientes (App Móvil)

- **Autenticación y Perfil Personal** 👤: Registro seguro, inicio de sesión y gestión de perfil y dirección de envío.
- **Catálogo de Servicios y Productos** 🛍️: Explora servicios (filtrables por categoría) y productos de cuidado personal.
- **Agendamiento de Citas** 📅: Reserva citas de forma intuitiva seleccionando sucursal, servicio, fecha y personal de preferencia (opcional). El pago de las citas se realiza en la sucursal.
- **Órdenes de Productos** 💳: Compra productos con un flujo de e-commerce completo, con pagos online seguros a través de **PayPal y MercadoPago**.
- **Historial y Reseñas** 📜: Consulta tu historial de citas y órdenes, y deja reseñas sobre los servicios, las cuales serán moderadas por un administrador.

### 💼 Para Administradores (Panel de Admin)

- **Gestión por Roles** 👑: Permisos claramente definidos para `Gerente`, `Admin Sucursal` y `Empleado`.
- **Promoción de Personal** 📈: Un flujo único donde un `Admin Sucursal` puede "promover" a un `Cliente` para convertirlo en `Empleado` de su sucursal, y un `Gerente` puede promover a un `Empleado` a `Admin Sucursal`.
- **Gestión de Catálogo Global** 📚: Los `Gerentes` tienen control total sobre Sucursales, Categorías, Servicios y Productos para toda la cadena.
- **Gestión de Agendamientos** 🗓️: Los administradores pueden ver la agenda de su sucursal, confirmar citas con personal específico y gestionar su estado.
- **Moderación de Reseñas** ✍️: Aprueba o rechaza las reseñas enviadas por los clientes antes de que sean públicas. Si un cliente edita su reseña, esta vuelve a requerir moderación.

## 🛠️ Stack Tecnológico

- **Backend**: Laravel 11 (PHP 8.2+)
- **Arquitectura**: Diseño Orientado al Dominio (DDD) con separación estricta por contextos (`Admin`, `Catalog`, `Client`, `Payments`, `Scheduling`).
- **Base de Datos**: MySQL 8.0+
- **Autenticación API**: **OAuth2** con **Laravel Passport**, ideal para aplicaciones móviles y de terceros de forma segura.
- **Documentación API**: Generada automáticamente con `l5-swagger` para una fácil integración.

## 🚀 Instalación Local

1.  **Clonar el repositorio**:
    ```bash
    git clone [https://github.com/roddek-dev/bmspa_laravel.git](https://github.com/roddek-dev/bmspa_laravel.git)
    cd bmspa_laravel
    ```

2.  **Instalar dependencias de PHP**:
    ```bash
    composer install
    ```

3.  **Configurar el entorno**:
    - Copia `.env.example` a `.env`: `cp .env.example .env`
    - Genera la clave de la aplicación: `php artisan key:generate`
    - Configura tus variables de base de datos (`DB_DATABASE`, `DB_USERNAME`, etc.) en el archivo `.env`.

4.  **Ejecutar las migraciones**:
    ```bash
    php artisan migrate
    ```

5.  **Configurar Laravel Passport (OAuth2)**:
    ```bash
    php artisan passport:install
    ```

6.  **Servir la aplicación**:
    ```bash
    php artisan serve
    ```
    Tu API estará disponible en `http://localhost:8000`.

## 📂 Estructura del Proyecto (DDD)

El código fuente en `src/` está organizado por contextos de negocio para máxima claridad:


src/
├── Admin/            # Lógica de gestión global (Sucursales, Personal, Categorías, etc.)
├── Catalog/          # Gestión del catálogo central de Productos y Servicios.
├── Client/           # Funcionalidades del cliente (Autenticación, Órdenes, Reseñas).
├── Payments/         # Lógica para procesar pagos con pasarelas externas.
└── Scheduling/       # Todo lo relacionado con Citas y Horarios.

Cada módulo interno sigue una estructura de capas: `application/`, `domain/`, e `infrastructure/`.

## 🎭 Roles y Permisos Detallados

El acceso a la API está estrictamente controlado por los siguientes roles:

| Rol | Descripción | Permisos Clave en la API |
| :--- | :--- | :--- |
| **Cliente** | Rol por defecto para cualquier usuario registrado. | • Gestionar su perfil y dirección.<br>• Crear y ver sus propias citas y órdenes.<br>• Crear, editar y eliminar sus propias reseñas. |
| **Empleado** | Personal operativo (barberos, estilistas). | • Consultar su agenda de citas asignadas.<br>• Cambiar el estado de sus citas.<br>• Consultar catálogos. |
| **Admin Sucursal** | Administrador de una única sucursal. | • Hereda permisos de Empleado.<br>• CRUD de servicios y productos para su sucursal.<br>• Promover Clientes a Empleados.<br>• Moderar reseñas de su sucursal. |
| **Gerente** | Máxima autoridad con acceso global. | • Hereda todos los permisos.<br>• CRUD global de Sucursales, Categorías, Promociones.<br>• Promover Empleados a Admin Sucursal. |

## 👨‍💻 Equipo de Desarrollo
- Rody Esteban Ávila Bohórquez
- Carlos Estiven Rodríguez Niño
- Daniel Esteban Ortiz Pinzón
- Daniel Armando Gómez Chaparro

## 📜 Licencia

Este proyecto está bajo la **Licencia MIT**.
