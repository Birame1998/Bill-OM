<?php
namespace App;

use App\Models\User;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = resource_path('data/users.csv');
        if (($handle = fopen($file, "r")) !== FALSE) {
            $header = null;
            $data = array();
            $final = array();
            while (($row = fgetcsv($handle, 2000,";")) !== false)
            {
                $row = array_map("utf8_encode", $row); //added

                if (!$header){
                    $header = $row;
                }
                else{
                    $data[] = array_combine($header, $row);
                }
            }
            for ($i = 0; $i < count($data); $i ++)
            {
                $final[]= $data[$i];
                unset($data[$i]['role']);
                $Admin = User::create($data[$i]);
                $Admin->assignRole($final[$i]['role']);
            }
            fclose($handle);
        }


        // $superAdmin = User::create(array(
        //     'email' => 'super@test.mail',
        //     'nom' => 'SUPER',
        //     'prenom' => 'super',
        //     'login_windows' => 'super123',
        //     'password' => bcrypt('super'),
        //     'role_base' => 1,
        //     'created_by' => 1,
        //     'structure_id' => 1
        // ));

        // $superAdmin->assignRole(1);
        /*
            $Admin = User::create(array(
                'email' => 'CONTROLLEUR2@test.gmail',
                'nom' => b'SUPERé',
                'prenom' => 'super',
                'password' => bcrypt('super'),
                'created_by' => 1,
                'structure_id' => 1
            ));
            $Admin->assignRole(2);
        */
    }
}

