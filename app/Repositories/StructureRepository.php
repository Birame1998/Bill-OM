<?php namespace App\Repositories;

use App\Models\GestionStructure\Structure;

class StructureRepository
{
    public function getAll(){
        return Structure::get();
    }

    public function findBy($id){
        return Structure::where('id',$id)->first();
    }
}
