<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateExpiredBatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:update-expired-batches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of expired batches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = \App\Models\Batch::query()
            ->where('expiry_date', '<', now())
            ->where('status', '!=', \App\Enums\BatchStatus::Expired)
            ->update(['status' => \App\Enums\BatchStatus::Expired]);

        $this->info("Updated {$count} expired batches.");
    }
}
