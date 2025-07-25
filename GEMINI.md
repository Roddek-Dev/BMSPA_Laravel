# Contexto y Reglas para el Proyecto: BarberMusic&Spa (Backend)

## 1. Resumen del Proyecto y Objetivo

El objetivo es desarrollar el backend para la aplicación web de una barbería y spa con múltiples sedes en México. El sistema debe gestionar clientes, personal, citas, servicios y operaciones de sucursal según los roles y la arquitectura definidos.

## 2. Principios Fundamentales (Reglas Críticas)

1.  **Arquitectura Hexagonal Obligatoria**: TODO el código debe residir dentro del directorio `src/`, organizado por módulos y capas (dominio, aplicación, infraestructura). **NUNCA** se debe colocar lógica de negocio o infraestructura en `app/`.
2.  **Documentación Swagger en Línea**: Las definiciones de esquemas (`@OA\Property`) para los endpoints DEBEN estar **siempre en línea** dentro de `@OA\JsonContent` en el controlador. **NUNCA** usar bloques `@OA\Schema` globales al final del archivo. **IMPORTANTE**: Solo debe existir una anotación `@OA\Info` global en todo el proyecto (generalmente en `app/Http/Controllers/Controller.php`). **NUNCA** añadir `@OA\Info` en controladores específicos de módulos.
3.  **Fuente de Verdad de la BD**: La estructura de la base de datos, nombres de tablas y columnas se rigen **estrictamente** por el archivo `dump-bmspa_arquitecture_hexagonal_laravel-202507181922.sql`. Los modelos y repositorios deben usar los nombres de columna exactos (`snake_case`).
4.  **Autenticación y Middleware**: La autenticación para rutas de la API **SIEMPRE** usa el guard `auth:api` (JWT). El middleware de roles (`CheckRole`) distingue el acceso según el rol del usuario autenticado.

## 3. Arquitectura de Software

### Arquitectura Hexagonal

-   **Principio General**: Separación estricta de capas: `domain`, `application`, `infrastructure`.
-   **Módulo de Clientes/Usuarios**: Implementación completa de Arquitectura Hexagonal y **Domain-Driven Design (DDD)** para modelar la lógica de negocio del usuario.
-   **Otros Módulos** (Agendamientos, Sucursales, etc.): Implementación funcional de Arquitectura Hexagonal, priorizando la separación de capas sin la complejidad completa de DDD.

## 4. Base de Datos (Esquema MySQL)

La estructura completa está definida en `dump-bmspa_arquitecture_hexagonal_laravel-202507181922.sql`.

-   **Relación Usuario-Personal**: Un registro en `usuarios` con `rol` = `'EMPLEADO'` **DEBE** tener un registro asociado en la tabla `personal`.
-   **Relaciones Polimórficas**: Tablas como `direcciones` y `reseñas` se asocian a múltiples modelos (sucursales, usuarios).
-   **Tablas Pivot**: Se usan para relaciones muchos a muchos (e.g., `servicio_sucursal`, `especialidad_personal`).
-   **Borrado Lógico (Soft Deletes)**: Tablas críticas (`usuarios`, `personal`, `sucursales`, etc.) usan el campo `deleted_at`. **SIEMPRE** se debe implementar borrado lógico para ellas.

## 5. Roles y Permisos de Usuario

El sistema tiene 4 roles con una jerarquía clara. El middleware `CheckRole` realiza la validación de manera **insensible a mayúsculas o minúsculas**.

| Rol | Descripción | Permisos Clave |
| :--- | :--- | :--- |
| **Cliente** | Rol por defecto para cualquier usuario registrado. | - Gestionar su propio perfil y citas (`agendamientos`).<br>- Realizar compras (`ordenes`).<br>- Publicar `reseñas`. |
| **Empleado** | Personal operativo que presta los servicios (barberos, estilistas). | - Consultar su agenda de citas.<br>- Cambiar estado de citas (COMPLETADA, CANCELADA).<br>- Consultar órdenes de productos. |
| **Admin Sucursal** | Administrador de una única sucursal. | - **Gestión de Catálogo (SU sucursal)**: CRUD de servicios y productos.<br>- **Gestión de Personal (SU sucursal)**: Promover `Cliente` a `Empleado`.<br>- **Moderación**: Aprobar/rechazar `reseñas` de su sucursal.<br>- **Desactivación**: Borrado lógico de `Clientes` y `Empleados` de su sucursal. |
| **Gerente (Super Admin)** | Máxima autoridad con acceso global a todo el sistema. | - **Hereda todos los permisos inferiores**.<br>- **Gestión Global**: CRUD de `Sucursales`, `Promociones`, `Especialidades`.<br>- **Gestión de Personal Global**: Promover `Empleado` a `Admin Sucursal`.<br>- Activar/Desactivar cualquier cuenta de `usuarios` o `personal`. |

## 6. Directrices de Implementación Técnica

#### **Estructura de Archivos y Namespaces**
-   **Ubicación**: Todos los componentes de infraestructura (Controladores, Modelos Eloquent, Form Requests, etc.) van **DENTRO** de `src/infrastructure/` del módulo correspondiente.
-   **Namespaces**: Deben reflejar la ruta exacta del archivo. Ejemplo: `Src\Client\reseñas\infrastructure\Http\Controllers\ReseñaController`.
-   **Nomenclatura Exacta de Archivos**: Verificar siempre la nomenclatura exacta de los archivos (ej. `CategoriaModel.php` vs `Categoria.php`) para evitar errores de "File not found" o referencias incorrectas.

#### **Documentación Swagger (OpenAPI)**
-   **REGLA CRÍTICA**: Los esquemas deben ser **en línea** dentro de `@OA\JsonContent`. **NO** usar bloques de Schema globales.
    -   **Ejemplo de lo que NO hacer**: `@OA\JsonContent(ref="#/components/schemas/MiEsquema")`
    -   **Ejemplo de lo que SÍ hacer**: `@OA\JsonContent(@OA\Property(property="campo", type="string", example="valor"))`
-   **Rutas Completas en `@OA\Path`**: Asegurarse de que el `path` en las anotaciones `@OA\Path` en los controladores incluya el prefijo completo de la ruta definido en `routes/api.php` **Y** el nombre del recurso si se usa `Route::resource`.
    -   **Ejemplo**: Si `routes/api.php` tiene `Route::prefix('Admin_modulo')->group(...)` y el archivo de rutas del módulo tiene `Route::resource('recurso', ...)`, entonces el `path` en el controlador debe ser `/api/Admin_modulo/recurso`.
-   **Referencia**: Seguir el patrón del archivo `Src\Client\usuarios\infrastructure\Http\Controllers\AuthController.php`.
-   **Autenticación**: Usar `security={{"bearerAuth":{}}}`. **NUNCA** usar `sanctum`.
-   **Configuración `l5-swagger`**: En `config/l5-swagger.php`, la sección `paths.annotations` **DEBE** incluir `base_path('src/')` y `base_path('app')`.

#### **Manejo de Entidades y Repositorios**
-   **Consistencia de Constructores**: El número y tipo de argumentos en el constructor de las entidades de dominio (`domain/Entities/`) DEBEN coincidir exactamente con los datos pasados desde las implementaciones de los repositorios (`infrastructure/Persistence/`), especialmente al mapear modelos Eloquent a entidades de dominio.

#### **Inyección de Dependencias**
-   **Propósito**: Resolver interfaces de dominio a implementaciones de infraestructura.
-   **Mecanismo**:
    1.  Crear un `ServiceProvider` por módulo (ej. `Src\Client\reseñas\infrastructure\Providers\ReseñaServiceProvider`).
    2.  Registrar el `bind` de la interfaz al repositorio concreto en ese proveedor.
    3.  Registrar el `ServiceProvider` del módulo en `bootstrap/app.php` usando `->withProviders([])`.

#### **Base de Datos y Nomenclatura**
-   **Fuente de Verdad**: El archivo `.sql` es la única referencia para nombres de tablas y columnas.
-   **Consistencia**: Usar nombres de columna exactos (`snake_case` como `cliente_usuario_id`) en modelos Eloquent (`$fillable`, relaciones) y repositorios.

## 7. Enfoque Actual del Proyecto

El foco principal es la implementación de las operaciones **CRUD** para cada entidad, **siguiendo estrictamente el modelo y la estructura del módulo de `categorias` como plantilla base**. Esto garantiza consistencia en la arquitectura, el enrutamiento y la documentación en todo el proyecto.

## 8. Directrices de Depuración

Cuando te encuentres con errores, especialmente relacionados con rutas, autenticación o autorización, sigue estos pasos sistemáticos:

1.  **Verificar Rutas Registradas**:
    *   Ejecuta `php artisan route:list --json` para obtener una lista detallada de todas las rutas registradas, incluyendo sus middlewares.
    *   Asegúrate de que la ruta que intentas acceder existe y que los middlewares (`api`, `auth:api`, `role:TU_ROL`) están aplicados correctamente.

2.  **Limpiar Caché de Laravel**:
    *   Después de cualquier cambio en rutas o configuración, siempre ejecuta:
        ```bash
        php artisan route:clear
        php artisan config:clear
        php artisan cache:clear
        php artisan view:clear
        ```
    *   Si estás usando `php artisan serve`, reinícialo después de limpiar la caché.

3.  **Revisar Configuración de Autenticación (JWT)**:
    *   Verifica `config/auth.php` para asegurar que el guard `api` esté configurado para usar el driver `jwt` y el provider de usuarios correcto.
    *   Revisa `config/jwt.php` para cualquier configuración errónea (secreto, TTL, etc.).

4.  **Depuración de Flujo de Ejecución (`dd()` o Logs)**:
    *   Si el error es "Unauthenticated" o "NotFoundHttpException" y las rutas parecen correctas, inserta `dd('Mensaje de depuración');` en puntos clave del código para rastrear dónde se detiene la ejecución o dónde los datos no son los esperados.
        *   **Ejemplo**: Al inicio del método del controlador, dentro del middleware, o en el repositorio.
    *   Utiliza `Log::info()` para registrar información en `storage/logs/laravel.log` si no quieres detener la ejecución.

5.  **Comparar con Módulos Funcionando**:
    *   Si un módulo similar funciona (ej. `categorias`), compara línea por línea los archivos relevantes (controlador, request, service, repository, provider, rutas) con el módulo que falla para identificar cualquier diferencia sutil.

