<?php
namespace App;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        // gestion accés
        Permission::create([
            "name" => "access_dashboard",
            "description" => "Accès dashboard",
            "tag" => "rubrique",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "gestion_acces",
            "description" => "Gestion accès",
            "tag" => "rubrique",
            "created_by" => 1
        ]);

        // gestion facturation
        Permission::create([
            "name" => "gestion_facture",
            "description" => "Gestion facture",
            "tag" => "rubrique",
            "created_by" => 1
        ]);


        //FACTURE
        Permission::create([
            "name" => "affichage_facture_envalidation",
            "description" => "Affichage facture en validation",
            "tag" => "facture",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "validation_facture",
            "description" => "Validation facture",
            "tag" => "facture",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "ajout_facture",
            "description" => "Ajout facture",
            "tag" => "facture",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "rejet_facture",
            "description" => "Rejet facture",
            "tag" => "facture",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "affichage_facture_valide",
            "description" => "Affichage facture validée",
            "tag" => "facture",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "export_facture",
            "description" => "Export facture",
            "tag" => "facture",
            "created_by" => 1
        ]);

        Permission::create([
            "name" => "affichage_facture_rejete",
            "description" => "Affichage facture rejetée",
            "tag" => "facture",
            "created_by" => 1
        ]);

        Permission::create([
            "name" => "affichage_facture_hors_catalogue",
            "description" => "Affichage facture hors catalogue",
            "tag" => "facture",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "rejouer_facture_hors_catalogue",
            "description" => "Rejouer facture hors catalogue",
            "tag" => "facture",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "affichage_recyclage_uv",
            "description" => "Affichage recyclage UV",
            "tag" => "facture",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "download_recyclage_uv",
            "description" => "Download recyclage UV",
            "tag" => "facture",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "affichage_catalogue",
            "description" => "Affichage catalogue",
            "tag" => "facture",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "creation_catalogue",
            "description" => "Création catalogue",
            "tag" => "facture",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "modification_catalogue",
            "description" => "Modification catalogue",
            "tag" => "facture",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "suppression_catalogue",
            "description" => "Suppression catalogue",
            "tag" => "facture",
            "created_by" => 1
        ]);

        // USER
        Permission::create([
            "name" => "creation_utilisateur",
            "description" => "Création utilisateur",
            "tag" => "user",
            "created_by" => 1
        ]);

        Permission::create([
            "name" => "affichage_utilisateur",
            "description" => "Affichage utilisateur",
            "tag" => "user",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "modification_utilisateur",
            "description" => "Modification utilisateur",
            "tag" => "user",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "suppression_utilisateur",
            "description" => "Suppression utilisateur",
            "tag" => "user",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "active_desactive_utilisateur",
            "description" => "Activation et désactivation des utilisateurs",
            "tag" => "user",
            "created_by" => 1
        ]);

        //INTERIMAIRE
        Permission::create([
            "name" => "ajout_interim",
            "description" => "Ajout intérim",
            "tag" => "user",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "affichage_interim",
            "description" => "Affichage intérim",
            "tag" => "user",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "modification_interim",
            "description" => "Modification intérim",
            "tag" => "user",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "arret_interim",
            "description" => "Arrêt intérim",
            "tag" => "user",
            "created_by" => 1
        ]);

        // ROLE
        Permission::create([
            "name" => "creation_role",
            "description" => "Création rôle",
            "tag" => "role",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "affichage_role",
            "description" => "Affichage rôle",
            "tag" => "role",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "modification_role",
            "description" => "Modification rôle",
            "tag" => "role",
            "created_by" => 1
        ]);
        Permission::create([
            "name" => "suppression_role",
            "description" => "Suppression rôle",
            "tag" => "role",
            "created_by" => 1
        ]);

         // crud operation permissions on user resource
        Permission::create([
            "name" => "affichage_permission",
            "description" => "Affichage permission",
            "tag" => "permission",
            "created_by" => 1
        ]);

        //Tracking
        Permission::create([
            "name" => "affichage_tracking",
            "description" => "Affichage tracking",
            "tag" => "tracking",
            "created_by" => 1
        ]);

    }
}
