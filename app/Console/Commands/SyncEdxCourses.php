<?php

namespace App\Console\Commands;

use App\Services\EdxSyncService;
use Illuminate\Console\Command;

class SyncEdxCourses extends Command
{
    protected $signature = 'edx:sync {--force : Force sync even if recently synced}';
    protected $description = 'Sync courses from edX API into local database';

    public function handle(EdxSyncService $syncService)
    {
        $this->info('Starting edX course sync...');

        $stats = $syncService->sync();

        $this->info("Sync completed:");
        $this->line("  Fetched: {$stats['fetched']}");
        $this->line("  Created: {$stats['created']}");
        $this->line("  Updated: {$stats['updated']}");
        $this->line("  Failed: {$stats['failed']}");

        return Command::SUCCESS;
    }
}