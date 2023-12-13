<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emails {type} {price?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
//       $price= $this->argument('price');
        //   dd($type );      // php artisan send:emails userss12345  bunu terminalda calisdirsaq  cavab olaraq userss12345  bu gelir
        Log::debug('Command worked!!');
        // php artisan schedule:work terminala yaziriq  bunu laravel.log da her deqiqe bu yazi cixir yeni loglanir


//        php artisan user:delete --user=5
//        php artisan users:delete {limit}


        // php artisan make:command UserDelete
    }
}
