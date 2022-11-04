<?php

namespace App\Console\Commands;

use App\Mail\SleppingAccount;
use App\Models\User;
use Illuminate\Console\Command;
use Mail;

class SleepingAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sleeping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $users= User::where('role_base',2)->get();
        if ($users->count()>0) {
            foreach ($users as $user) {
                Mail::to('moussadioufy37@gmail.com')->send(new SleppingAccount($user));
            }
        }
        return 0;
    }
}
