<?php

use Illuminate\Support\Facades\Route;
use Src\Payments\transacciones_pago\infrastructure\Http\Controllers\WebhookController;

// Webhook público para Mercado Pago (no requiere autenticación)
Route::post('webhooks/mercadopago-ipn', [WebhookController::class, 'mercadopagoIpn']);
