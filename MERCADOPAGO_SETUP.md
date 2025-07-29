# Configuración de Mercado Pago

## Variables de Entorno Requeridas

Agrega las siguientes variables a tu archivo `.env`:

```env
# Mercado Pago Configuration
MERCADOPAGO_ACCESS_TOKEN=your_mercadopago_access_token_here
MERCADOPAGO_PUBLIC_KEY=your_mercadopago_public_key_here

# Frontend URL for Mercado Pago redirects
FRONTEND_URL=http://localhost:3000
```

## Configuración de Mercado Pago

1. **Crear cuenta en Mercado Pago Developers**: https://www.mercadopago.com/developers
2. **Obtener credenciales**:
    - Access Token (para el backend)
    - Public Key (para el frontend)
3. **Configurar webhooks** en el panel de Mercado Pago:
    - URL: `https://tu-dominio.com/api/webhooks/mercadopago-ipn`
    - Eventos: `payment`

## Flujo de Integración

### 1. Creación de Orden con Pago

-   **Endpoint**: `POST /api/Client_ordenes/ordenes`
-   **Respuesta**: Incluye `preference_id` de Mercado Pago
-   **Estado**: Orden creada con estado `PENDIENTE_PAGO`

### 2. Procesamiento de Pago

-   **Webhook**: `POST /api/webhooks/mercadopago-ipn`
-   **Acción**: Actualiza orden a `PAGADA` y crea transacción
-   **Seguridad**: Verifica notificación con Mercado Pago

## Notas de Implementación

-   ✅ SDK de Mercado Pago instalado
-   ✅ Configuración de servicios agregada
-   ✅ Migración de transacciones creada
-   ✅ Webhook implementado
-   ✅ Integración con órdenes completada
-   ⚠️ **Pendiente**: Configurar variables de entorno
-   ⚠️ **Pendiente**: Probar en ambiente de desarrollo
