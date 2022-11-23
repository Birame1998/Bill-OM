<?php

namespace App\Models\Facturation;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use Uuids;
    protected $table = 'catalogue';
    protected $fillable = array('num_ap', 'nom_partenaire', 'type_partenaire_id', 'inclure_id', 'taux_commission',
                            'compte_bancaire', 'mode_reversement_id', 'commentaire','created_by');

    public function sim_designation()
    {
        return $this->hasMany(CatalogueHasSim::class, 'catalogue_id');
    } 
}
