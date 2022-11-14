<?php

namespace App\Http\Controllers;

use App\Models\Facturation\Catalogue;
use Illuminate\Http\Request;

class ApiCatalogueController extends Controller
{
    public function index(Request $request)
    {   
        $sim_head=$request->input('sim_head');
        $catalogue=Catalogue::whereHas('sim_designation',function($q) use ($sim_head)
            {
               $q->where('sim_head',$sim_head);
            })->orderBy('num_ap','DESC')->get(); 
        return $catalogue;
    }
}
