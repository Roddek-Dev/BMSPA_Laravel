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
        $this->app->bind(PagoService::class, PagoService::class);
    }

    public function boot(): void
    {
        //
    }
}
