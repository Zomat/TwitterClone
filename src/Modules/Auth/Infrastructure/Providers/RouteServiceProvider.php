<?php declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->name('auth.')
                ->group(base_path('src/Modules/Auth/Interface/Api/Routes/auth.php'));
        });
    }
}
