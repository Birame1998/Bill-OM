<?php

namespace App\Http\Controllers\Facturation;

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
        $facturation = Facturation::where("statut",3)->get();
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
