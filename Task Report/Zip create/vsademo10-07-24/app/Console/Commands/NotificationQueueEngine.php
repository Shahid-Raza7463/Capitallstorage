<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NotificationQueueEngine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificationqueue:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run notificationqueworker and process the senidng of notifications';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		    // Start the additional queue worker
    $this->call('queue:work', [
        '--queue' => 'CreateZip',
        '--stop-when-empty' => true,
    ]);
	
        return Command::SUCCESS;
    }
}
