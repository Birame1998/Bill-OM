<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facturation\Catalogue;
use Illuminate\Support\Facades\Response;

class ApiCatalogueController extends Controller
{
    public function index(Request $request)
    {   
        $sim_head=$request->input('sim_head');
        $catalogue=Catalogue::whereHas('sim_designation',function($q) use ($sim_head)
            {
               $q->where('sim_head',$sim_head);
            })->with(['sim_designation'])->orderBy('num_ap','DESC')->get(); 
        if ($catalogue->count()==0) {
            $data = [
                'error' => [
                    'message' => 'Partenaire non trouvé pour cette sim',
                    'statusCode' => 404
                ]
            ];
            return Response::json($data, 404);
        }else{
            return $catalogue;
        }
    }
}
