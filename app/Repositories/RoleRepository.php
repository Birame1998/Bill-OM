<?php namespace App\Repositories;

use Spatie\Permission\Models\Role;


class RoleRepository
{
    public function getAllNoSuper(){
        return Role::get();
    }

    public function getAll(){
        return Role::all();
    }

    public function getAllWithepermissions(){
        return Role::with(['permissions'])->get();

    }

}
