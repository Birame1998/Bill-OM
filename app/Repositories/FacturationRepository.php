<?php namespace App\Repositories;

use App\Models\Facturation\Catalogue;

class FacturationRepository
{
    public function getAll(){
        return Catalogue::get();
    }

}
