<?php

namespace App\Console\Commands;

use App\Http\Controllers\Facturation\FacturationValideController;
use Mail;
use Carbon\Carbon;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use App\Mail\SleppingAccount;
use Illuminate\Console\Command;
use App\Models\Facturation\Catalogue;
use App\Models\Facturation\Facturation;
use App\Repositories\UserRepository;

class SleepingAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:reporting';

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
        $userRepo=new UserRepository;
        $fctvCtrl=new FacturationValideController($userRepo);
       $pdf = $fctvCtrl->exportSleeping();
        if ($users->count()>0) {
            foreach ($users as $user) {
                Mail::to('moussadioufy37@gmail.com')->send(new SleppingAccount($user,$pdf));
            }
        }
        return 0;
    }
}
