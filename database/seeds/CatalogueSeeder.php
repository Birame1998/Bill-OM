<?php

use App\Classes\GestionFile;
use Illuminate\Database\Seeder;
use App\Models\Facturation\Catalogue;
use App\Models\Facturation\CatalogueHasSim;

class CatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $read = new GestionFile();
        $file = resource_path('data/catalogue_final.csv');
        $catalogue_insert = $read->csvToArrayStructure($file);
        for ($i = 0; $i<count($catalogue_insert); $i++)
        {
            $cat = Catalogue::where("num_ap",$catalogue_insert[$i]['num_ap'])->count();
            if($cat==0){
                Catalogue::create($catalogue_insert[$i]);
            }
        }

        $filesim = resource_path('data/cataloguehassim.csv');
        $catalogue_sim = $read->csvToArrayStructure($filesim);
        for ($i = 0; $i<count($catalogue_sim); $i++)
        {
            $cat = Catalogue::where("num_ap",$catalogue_sim[$i]['num_ap'])->first();
            CatalogueHasSim::create([
                    'catalogue_id' => $cat->id,
                    'sim_head' => $catalogue_sim[$i]['sim_head'],
                    'onglet_facturation_id' => $catalogue_sim[$i]['onglet_facturation_id'],
                    'blacklist_c2c' => $catalogue_sim[$i]['blacklist_c2c'],
                    'identifiant_designation' => $catalogue_sim[$i]['identifiant_designation']

                ]);
        }
    }
}
