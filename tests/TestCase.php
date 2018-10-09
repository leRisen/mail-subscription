<?php

namespace leRisen\MailSubscription\Tests;

use Mockery;
use leRisen\MailSubscription\MailSubscriptionServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [MailSubscriptionServiceProvider::class];
    }

    public function setUp()
    {
        parent::setUp();

        $this->app->setBasePath(__DIR__ . '/../');
        $router = $this->app['router'];

        $router->post('feedback', '\leRisen\MailSubscription\MailSubscriptionController@subscribe');

        $this->loadMigrationsFrom([
            '--database' => 'mailsubscription',
            '--path' => realpath(__DIR__ . '/migrations')
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
