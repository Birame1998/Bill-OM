<?php

use App\RoleSeeder;
use App\UserSeeder;
use App\PermissionSeeder;
use App\HorsCatalogueSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\CatalogueSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            StructureSeeder::class,
            CatalogueSeeder::class,
            FacturationSeeder::class
		]);
	}

}

