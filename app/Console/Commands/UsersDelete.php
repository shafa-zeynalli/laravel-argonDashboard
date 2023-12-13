<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UsersDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:delete {limit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::debug('UsersDelete command started.');
        $limit=$this->argument('limit');

        if (!$limit || !is_numeric($limit)) {
            Log::error('Invalid or missing limit value. Please provide a numeric limit using --user option.');
            return;
        }

        $deletedUsers = User::orderBy('id')->limit($limit)->delete();

//        $this->info("Successfully deleted {$deletedUsers} users.");
        Log::debug("Successfully deleted {$deletedUsers} users.");
        //php artisan schedule:work    bunu terminala yazib ise saliriq
    }
}
