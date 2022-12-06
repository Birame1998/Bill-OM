<?php

namespace App\Http\Controllers\Facturation;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Models\Facturation\Facturation;

class FacturationRejeteController extends Controller
{
    private $userRepo;
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepo = $userRepository;
    }

    public function index()
    {
        $info = $this->userRepo->infoConnect();
        $this->visiteLien($info,"liste facture rejetée");
        $facturation = Facturation::where("statut",3)->orderBy('date_transaction','DESC')->get();
        if (request('dates')!==null) {
            $dates=request('dates');    
            $from = Carbon::createFromFormat('d/m/Y',explode("-",preg_replace('/\s+/', '', $dates))[0])->format('Ymd');
            $to = Carbon::createFromFormat('d/m/Y',explode("-",preg_replace('/\s+/', '', $dates))[1])->format('Ymd');
            $facturation=Facturation::whereBetween('date_transaction',[$from,$to])->where("statut",3)->orderBy('date_transaction','DESC')->get();   
        }
        return view('Facturation.Facturation.index_rejetee',compact('facturation'));
    }

    public function show($id)
    {
        $info = $this->userRepo->infoConnect();
        $this->visiteLien($info,"détail facture rejetée");
        $facturation = Facturation::find($id);
        $onglet_facturation = $this->onglet_facturation[$facturation->onglet_facturation_id]['libelle'];
        return response()->json(['data' => $facturation, "onglet_facturation" => $onglet_facturation]);
    }
}
