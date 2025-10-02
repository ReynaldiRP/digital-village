<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearStorageImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:clear-images {--disk=public : The storage disk to clear.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all files from the specified storage disk.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $disk = $this->option('disk');

        // Add a confirmation prompt for safety
        if ($this->confirm("⚠️ Are you sure you want to delete ALL files from the '{$disk}' disk? This action cannot be undone.")) {

            $files = Storage::disk($disk)->allFiles();

            if (empty($files)) {
                $this->info("The '{$disk}' disk is already empty.");
                return;
            }

            Storage::disk($disk)->delete($files);

            $this->info("Successfully deleted all files from the '{$disk}' disk.");
        } else {
            $this->info('Operation cancelled.');
        }
    }
}
