<?php

namespace Kaynite\SMS\Providers;

use Illuminate\Support\ServiceProvider;
use Kaynite\SMS\Interfaces\SMSInterface;
use Kaynite\SMS\SMSManager;

class SMSServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sms.manager', function ($app) {
            return new SMSManager($app);
        });

        $this->app->bind(SMSInterface::class, function ($app) {
            return $app->make('sms.manager')->driver();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sms.php' => config_path('sms.php'),
        ]);
    }
}
