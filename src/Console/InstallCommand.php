<?php

namespace leRisen\MailSubscription\Console;

use Illuminate\Console\Command;
use leRisen\MailSubscription\MailSubscriptionServiceProvider;

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
        $this->info('Publishing config & database migration');
        $this->call('vendor:publish', ['--provider' => MailSubscriptionServiceProvider::class]);

        $this->info('Migrating `mail_subscribers` table into your application');
        $this->call('migrate');

        $this->info('Package successfully installed! Use ^^');
    }
}
