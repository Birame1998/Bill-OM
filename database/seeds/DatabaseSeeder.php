<?php

use App\RoleSeeder;
use App\UserSeeder;
use App\PermissionSeeder;
use Illuminate\Database\Seeder;


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
		]);
	}

}

