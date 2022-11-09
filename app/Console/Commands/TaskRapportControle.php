<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GestionStructure\Tracking;
use App\Models\GestionControlInterne\RapportControle;
use App\Models\GestionControlInterne\FicheValider;
use App\Models\GestionControlInterne\TypeControle;

class TaskRapportControle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hebdo';

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
        $rapport_hebdo = FicheValider::with(['fiche_controle','rapport_controle'])
                            ->get()->where('fiche_controle.periodicite.libelle','Hebdomadaire')
                            ->where('fiche_controle.statut_validation.libelle','Approuvée');
        foreach($rapport_hebdo as $val){
            RapportControle::create([
                'fiche_id' => $val->id,
                'statut_controle_id' => 3,
                'created_by' => 'Super Admin [System]'
            ]);
        }
    }
}
