<?php

namespace leRisen\MailSubscription\Console\Commands;

use Illuminate\Console\Command;
use leRisen\MailSubscription\Providers\MailSubscriptionServiceProvider;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail-subscription:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install package mail-subscription';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--provider' => MailSubscriptionServiceProvider::class]);
        $this->info('Publishing config & database migration <info>✔</info>');

        $this->call('migrate');
        $this->info('Migrating `mail_subscribers` table into your application <info>✔</info>');

        $this->info('Package successfully installed! Use ^^');
    }
}
