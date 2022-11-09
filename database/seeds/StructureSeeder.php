<?php

use Illuminate\Database\Seeder;
use App\Models\GestionStructure\Structure;
use App\Models\GestionStructure\Type_structure;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Structure::create(array(
            'libelle' => 'DO'
        ));
        Structure::create(array(
            'libelle' => 'DAF'
        ));
        Structure::create(array(
            'libelle' => 'DTI'
        ));
    }
}
