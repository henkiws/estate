<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class ProcessScheduledNotifications extends Command
{
    protected $signature = 'notifications:process-scheduled';
    protected $description = 'Process and send scheduled notifications';

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function handle()
    {
        $count = $this->notificationService->processScheduled();
        
        $this->info("Processed {$count} scheduled notifications.");
        
        return Command::SUCCESS;
    }
}