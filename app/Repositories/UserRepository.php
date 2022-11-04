<?php namespace App\Repositories;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\GestionSecurite\Poste;
use Spatie\Permission\Models\Permission;
use App\Models\GestionStructure\Structure;

class UserRepository
{
    public function getAll() {
        return User::with(['roles'])->where('id', '!=', 1)
                ->where('id', '!=', Auth::id())->get();
    }

    public function getAllResponsable() {
        return User::with(['roles'])->where('id', '!=', 1)->get();
    }

    public function findBy($id){
        return User::with(['roles'])->where('id',$id)->first();
    }

    public function infoConnect(){
        $user = User::with(['structure'])->where('id',Auth::id())->first();
        return $user->prenom." ".$user->nom." [".$user->structure->libelle."]";
    }

}
