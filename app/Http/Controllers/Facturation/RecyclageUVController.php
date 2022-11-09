<?php

namespace App\Http\Controllers\Facturation;

use Illuminate\Http\Request;
use App\Models\Facturation\RecyclageUV;
use App\Http\Controllers\Controller;

class RecyclageUVController extends Controller
{
    public function index()
    {
        $recyclage = RecyclageUV::get();
        return view('Facturation.Facturation.index_recyclage_uv',compact('recyclage'));
    }
}
