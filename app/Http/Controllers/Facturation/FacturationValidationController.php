<?php

namespace App\Http\Controllers\Facturation;

use DateTime;

use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Models\Facturation\Facturation;

class FacturationValidationController extends Controller
{
    private $userRepo;
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepo = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = $this->userRepo->infoConnect();
        $this->visiteLien($info,"liste facture en validation");
        $facturation = Facturation::where("statut",1)->get();
        return view('Facturation.Facturation.index_envalidation',compact('facturation'));
    }

    public function search(Request $request){
        $recherche = $this->recherche($request->nom_partenaire,$request->dates);
        $facturation = $recherche[0];
        $nom_partenaire = $recherche[1];
        $dates = $recherche[2];
        return view('Facturation.Facturation.index_envalidation',compact('facturation','nom_partenaire', 'dates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $info = $this->userRepo->infoConnect();
        $validation_do = Carbon::now()->format('YmdHis');
        if($request->selected_id){
            Facturation::whereIn('id', $request->selected_id)
            ->update([
                'statut' => 2,
                'valider_par' => $info,
                'validation_do' => $validation_do]
                ,['timestamps' => false]
            );
            if (count($request->selected_id)==1){
                session()->flash("message_success","La facture a été validée avec succès.");
            }
            else{
                session()->flash("message_success","Les factures ont été validées avec succès.");
            }
        }
        else{
            session()->flash("message","Aucune facture n'a été sélectionnée.");
        }
        return redirect()->route('facturation_envalidation.index');
    }

    public function rejet(Request $request){
        $info = $this->userRepo->infoConnect();
        $rejet_do = Carbon::now()->format('YmdHis');
        if($request->selected_id){
            Facturation::whereIn('id', $request->selected_id)
            ->update([
                'statut' => 3,
                'motif_rejet_do' => $request->motif_rejet,
                'rejeter_par' => $info,
                'rejet_do' => $rejet_do],
                ['timestamps' => false]);
            if (count($request->selected_id)==1){
                session()->flash("message","La facture a été rejetée avec succès.");
            }
            else{
                session()->flash("message","Les factures ont été rejetées avec succès.");
            }
        }
        else{
            session()->flash("message","Aucune facture n'a été sélectionnée.");
        }
        return redirect()->route('facturation_envalidation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = $this->userRepo->infoConnect();
        $this->visiteLien($info,"détail facture en validation");
        $facturation = Facturation::find($id);
        $onglet_facturation = $this->onglet_facturation[$facturation->onglet_facturation_id]['libelle'];
        return response()->json(['data' => $facturation, "onglet_facturation" => $onglet_facturation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
