<?php

namespace leRisen\MailSubscription\Providers;

use Illuminate\Support\ServiceProvider;
use leRisen\MailSubscription\Console\Commands;

class MailSubscriptionServiceProvider extends ServiceProvider
{
    const PACKAGE_DIR = __DIR__.'/../../';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        $this->loadMigrationsFrom(self::PACKAGE_DIR.'/database/migrations');
        $this->loadTranslationsFrom(self::PACKAGE_DIR.'/resources/lang', 'translate-mailsubscription');

        $this->publishes([
            self::PACKAGE_DIR.'/config/mailsubscription.php' => config_path('mailsubscription.php'),
        ], 'config');

        $this->publishes([
            self::PACKAGE_DIR.'database/migrations/' => database_path('migrations'),
        ], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->commands(Commands\InstallCommand::class);
        }
    }
}
