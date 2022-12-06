<?php

namespace App;


use Illuminate\Database\Seeder;
use App\Models\Facturation\HorsCatalogue;



class HorsCatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HorsCatalogue::factory()
        ->count(200)
        ->create();
    }
}
