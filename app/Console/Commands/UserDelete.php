<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UserDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete {--user=}';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Deleting a limited number of users ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::debug('UserDelete command started.');
        $limit=$this->option('user');

        if (!$limit || !is_numeric($limit)) {
            Log::error('Invalid or missing limit value. Please provide a numeric limit using --user option.');
            return;
        }

        $deletedUsers = User::orderBy('id')->limit($limit)->delete();

//        $this->info("Successfully deleted {$deletedUsers} users.");
        Log::debug("Successfully deleted {$deletedUsers} user.");
        //php artisan schedule:work    bunu terminala yazib ise saliriq
    }
}
