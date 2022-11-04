<?php
namespace App;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $super = Role::create([
            "name" => "Super Admin",
            "description" => "Super administrateur",
            "created_by" => 1
        ]);
        $super->syncPermissions(range(1,33));
        /***************PROFIL DO********************/
		// Role::create([
        //     "name" => "DORESPOF",
        //     "description" => "DO Responsable POF",
        //     "created_by" => 1
        // ]);
        // Role::create([
        //     "name" => "DORESPOF_INTERIMDOCHEFDEPT",
        //     "description" => "DO Responsable POF - Interim DO Chef Dept",
        //     "created_by" => 1
        // ]);
        $METIERDO = Role::create([
            "name" => "METIERDO",
            "description" => "Métier DO",
            "created_by" => 1
        ]);
        $ra= range(1, 18);
        $b = array(2);
        $tab = array_diff($ra, $b);
        $METIERDO->syncPermissions($tab);

        // $DOCHEFDEPT = Role::create([
        //     "name" => "DOCHEFDEPT",
        //     "description" => "DO Chef Dept",
        //     "created_by" => 1
        // ]);

        // Role::create([
        //     "name" => "DOCHEFDEPT_INTERIMDORESPOF",
        //     "description" => "DO Chef Dept - Intérim DO Responsable POF",
        //     "created_by" => 1
        // ]);

        // Role::create([
        //     "name" => "METIERDO_INTERIMDORESPOF",
        //     "description" => "Métier DO - Intérim DO Responsable POF",
        //     "created_by" => 1
        // ]);
        // Role::create([
        //     "name" => "METIERDO_INTERIMDOCHEFDEPT",
        //     "description" => "Métier DO - Intérim DO Chef Dept",
        //     "created_by" => 1
        // ]);
        /***************PROFIL DO********************/

        /***************PROFIL DAF********************/
        // Role::create([
        //     "name" => "DAFRESCOMPT",
        //     "description" => "DAF Responsable Comptable",
        //     "created_by" => 1
        // ]);
        // Role::create([
        //     "name" => "DAFRESCOMPT_INTERIMDAFCHEFDEPT",
        //     "description" => "DAF Responsable Comptable - Intérim DAF Chef Dept",
        //     "created_by" => 1
        // ]);

        // Role::create([
        //     "name" => "DAFCHEFDEPT",
        //     "description" => "DAF Chef Dept",
        //     "created_by" => 1
        // ]);

        $METIERDAF = Role::create([
            "name" => "METIERDAF",
            "description" => "Métier DAF",
            "created_by" => 1
        ]);
        $rc= range(1, 18);
        $c = array(2,5,6,7,12,16,17,18);
        $tabc = array_diff($rc, $c);
        $METIERDAF->syncPermissions($tabc);
        // Role::create([
        //     "name" => "DAFCHEFDEPT_INTERIMDAFRESCOMPT",
        //     "description" => "DAF Chef Dept - Intérim Responsable Comptable",
        //     "created_by" => 1
        // ]);

        // Role::create([
        //     "name" => "METIERDAF_INTERIMDAFRESCOMPT",
        //     "description" => "Métier DAF - Intérim Responsable Comptable",
        //     "created_by" => 1
        // ]);
        // Role::create([
        //     "name" => "METIERDAF_INTERIMDAFCHEFDEPT",
        //     "description" => "Métier DAF - Intérim DAF Chef Dept",
        //     "created_by" => 1
        // ]);

        $CONSULTATION = Role::create([
            "name" => "Consultation",
            "description" => "Consultation",
            "created_by" => 1
        ]);
        $CONSULTATION->syncPermissions($tabc);
    }
}
