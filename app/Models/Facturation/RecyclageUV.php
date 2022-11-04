<?php

namespace App\Models\Facturation;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class RecyclageUV extends Model
{
    use Uuids;
    protected $table = 'recyclage_uv';
    protected $fillable = array('c2c', 'ow', 'date');

}
