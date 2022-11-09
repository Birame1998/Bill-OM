<?php

use App\Classes\GestionFile;
use Illuminate\Database\Seeder;
use App\Models\Facturation\Facturation;

class FacturationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $read = new GestionFile();
        $fileFacture = resource_path('data\facturation.csv');
        $facture = $read->csvToArrayStructure($fileFacture);
        for ($i = 0; $i<count($facture); $i++)
        {
            Facturation::create($facture[$i]);
        }
    }
}
