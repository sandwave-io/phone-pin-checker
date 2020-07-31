<?php declare(strict_types = 1);

namespace Sandwave\PhonePinChecker;

use Illuminate\Support\ServiceProvider;

class PhonePinCheckerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PhonePinChecker::class, function ($app) {
            return new PhonePinChecker(app('cache'), config('phone-pin-checker.expire'));
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/phone-pin-checker.php',
            'phone-pin-checker'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/phone-pin-checker.php' => config_path('phone-pin-checker.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
