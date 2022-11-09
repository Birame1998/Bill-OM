<?php

namespace App\Models\Facturation;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class HorsCatalogue extends Model
{
    use Uuids;
    protected $table = 'hors_catalogue';
    protected $fillable = array('parent_user_msisdn', 'transaction_amount', 'date');

}
