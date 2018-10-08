<?php

namespace leRisen\MailSubscription;

use Illuminate\Support\ServiceProvider;

class MailSubscriptionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make('leRisen\MailSubscription\MailSubscriptionController');

        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'translate-mailsubscription');

        $this->publishes([
            __DIR__.'/config/mailsubscription.php' => config_path('mailsubscription.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/migrations/' => database_path('migrations'),
        ], 'migrations');
    }
}
