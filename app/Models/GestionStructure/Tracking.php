<?php

namespace App\Models\GestionStructure;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = 'tracking';
    protected $fillable = array('user', 'action', 'ip_machine', 'url');

}
