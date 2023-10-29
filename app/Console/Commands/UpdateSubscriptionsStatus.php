<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateSubscriptionsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-subscriptions-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command runs on daily basis and will update status to cancelled for expired subscriptions in DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        updateSubscriptionsStatus();
    }
}
