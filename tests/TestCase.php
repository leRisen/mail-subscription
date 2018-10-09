<?php

namespace leRisen\MailSubscription\Tests;

use leRisen\MailSubscription\Providers\MailSubscriptionServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [MailSubscriptionServiceProvider::class];
    }

    protected function setUp()
    {
        parent::setUp();

        $this->app->setBasePath(__DIR__.'/../');

        $this->loadMigrationsFrom([
            '--database' => 'mailsubscription',
            '--path'     => realpath(__DIR__.'/../../migrations'),
        ]);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'mailsubscription');
        $app['config']->set('database.connections.mailsubscription', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('app.locale', 'en');
    }
}
