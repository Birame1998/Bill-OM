<?php

namespace App\Models\Facturation;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class CatalogueHasSim extends Model
{
    use Uuids;
    protected $table = 'catalogue_has_sim';
    protected $fillable = array('catalogue_id', 'sim_head', 'identifiant_designation', 'onglet_facturation_id', 'blacklist_c2c', 'taux_commission');

}
