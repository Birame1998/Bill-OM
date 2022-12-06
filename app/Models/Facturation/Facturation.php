<?php

namespace App\Models\Facturation;

use Carbon\Carbon;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Facturation extends Model
{
    use Uuids;
    protected $table = 'facturation';
    public $timestamps = false;
    protected $fillable = array('num_ap','statut','nom_partenaire', 'sim_head', 'transaction_amount', 'commission',
                            'a_reverser', 'compte_bancaire', 'onglet_facturation_id', 'date_transaction',
                        'motif_rejet_do', 'validation_do', 'rejet_do', 'rejouer', 'valider_par','rejeter_par','a_afficher');

    public function sim_designation()
    {
        return $this->hasMany(CatalogueHasSim::class, 'catalogue_id');
    }
}
