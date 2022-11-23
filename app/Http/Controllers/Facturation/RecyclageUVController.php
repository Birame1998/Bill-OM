<?php

namespace App\Http\Controllers\Facturation;

use Illuminate\Http\Request;
use App\Models\Facturation\RecyclageUV;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class RecyclageUVController extends Controller
{
    public function index()
    {
        $recyclage = RecyclageUV::orderBy('date','DESC')->paginate(10);
        if (request('dates')!==null) {
        $dates=request('dates');    
        $from = Carbon::createFromFormat('d/m/Y',explode("-",preg_replace('/\s+/', '', $dates))[0])->format('Ymd');
        $to = Carbon::createFromFormat('d/m/Y',explode("-",preg_replace('/\s+/', '', $dates))[1])->format('Ymd');
        $recyclage=RecyclageUV::whereBetween('date',[$from,$to])->orderBy('date','DESC')->paginate(10);   
        }
        return view('Facturation.Facturation.index_recyclage_uv',compact('recyclage'));
    }
}
