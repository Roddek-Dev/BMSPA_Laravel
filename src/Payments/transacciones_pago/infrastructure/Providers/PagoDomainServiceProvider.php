<?php

declare(strict_types=1);

namespace Src\Payments\transacciones_pago\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Payments\transacciones_pago\domain\Repositories\TransaccionPagoRepository;
use Src\Payments\transacciones_pago\infrastructure\Persistence\EloquentTransaccionPagoRepository;
use Src\Payments\transacciones_pago\application\PagoService;

class PagoDomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TransaccionPagoRepository::class, EloquentTransaccionPagoRepository::class);
        
        // Registrar PagoService solo si las credenciales de MercadoPago están configuradas
        if (config('services.mercadopago.access_token')) {
            $this->app->bind(PagoService::class, PagoService::class);
        } else {
            // Registrar un servicio nulo si no hay configuración
            $this->app->bind(PagoService::class, function () {
                return null;
            });
        }
    }

    public function boot(): void
    {
        //
    }
}
