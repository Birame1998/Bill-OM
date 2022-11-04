<?php

namespace App\Models\GestionStructure;

use ErrorException;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\GestionControlInterne\Fiche;
use App\Models\GestionStructure\Type_structure;

class Structure extends Model
{
    protected $table = 'structures';
    protected $fillable = array('libelle', 'created_by');

    public function user()
    {
        return $this->hasMany(User::class, 'structure_id');
    }
}
