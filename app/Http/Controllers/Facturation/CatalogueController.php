<?php

namespace App\Http\Controllers\Facturation;

use App\Classes\GestionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Http;
use App\Models\Facturation\Catalogue;
use App\Models\GestionStructure\Tracking;
use App\Models\Facturation\CatalogueHasSim;

class CatalogueController extends Controller
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
        $this->visiteLien($info,"liste catalogue");
if (request('search') && request('search2')==null) {
    $id=0;
    foreach($this->onglet_facturation as $onglet){
        if (request('search')==$onglet['libelle']) {
           $id=$onglet['id'];
           //dd($id);
        }
           $catalogue=Catalogue::whereHas('sim_designation',function($q) use ($id)
            {
               $q->where('onglet_facturation_id',$id);
            })->orderBy('num_ap','DESC')->paginate(15);
    }
} elseif(request(('search2')) && request('search')==null){
     $catalogue=Catalogue::with(['sim_designation'])->where('nom_partenaire',request('search2'))->orderBy('num_ap','DESC')->paginate(15);
}
elseif(request('search') && request('search2')){
    $id=0;
    foreach($this->onglet_facturation as $onglet){
        if (request('search')==$onglet['libelle']) {
           $id=$onglet['id'];
        }
           $catalogue=Catalogue::whereHas('sim_designation',function($q) use ($id)
            {
               $q->where('onglet_facturation_id',$id);
            })->where('nom_partenaire',request('search2'))->orderBy('num_ap','DESC')->paginate(15);
    }
}
else{
    $catalogue = Catalogue::with(['sim_designation'])->orderBy('num_ap','DESC')->paginate(15);
}
return view('Facturation.Catalogue.index')->with('catalogue',$catalogue);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $info = $this->userRepo->infoConnect();
        $this->visiteLien($info,"création catalogue");
        return view('Facturation.Catalogue.create');
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
        //dd($request);
        try {
            $catalogue = Catalogue::create([
                'num_ap' => $request->num_ap,
                'nom_partenaire' => $request->nom_partenaire,
                'type_partenaire_id' => $request->type_partenaire_id,
                'inclure_id' => $request->inclure_id,
                'compte_bancaire' => $request->compte_bancaire,
                'mode_reversement_id' => $request->mode_reversement_id,
                'commentaire' => $request->commentaire,
                'created_by' => $info,
            ]);
            foreach($request->car as $req)
            {
                CatalogueHasSim::create([
                    'catalogue_id' => $catalogue->id,
                    'sim_head' => $req['sim_head'],
                    'identifiant_designation' => $req['id_designation'],
                    'taux_commission' => $req['taux_commission'],
                    'onglet_facturation_id' => $req['onglet_facturation_id'],
                    'blacklist_c2c' => $req['blacklist_c2c']
                ]);
            }

            Tracking::create([
                'user' => $info,
                'action' => "a créé le catalogue num_ap: ".$request->num_ap." ,nom_partenaire: ".
                            $request->nom_partenaire." ,type_partenaire: ".$this->type_partenaire[$request->type_partenaire_id]['libelle'].
                            " ,inclure: ".$this->inclure[$request->inclure_id]['libelle']." ,taux_commission: ".$request->taux_commission.
                            " ,compte_bancaire: ".$request->compte_bancaire." ,commentaire: ".$request->commentaire." ,mode_reversement: ".$this->mode_reversement[$request->mode_reversement_id]['libelle'].
                            " ,sim_head, identifiant_designation, onglet_facturation_id et blacklist_c2c: ".json_encode($request->car),
                'ip_machine' => request()->ip(),
                'url' => url()->current()
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","Le catalogue existe déjà dans le système.");
            return redirect()->route('catalogue.create');
        }
        return redirect()->route('catalogue.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = $this->userRepo->infoConnect();
        $this->visiteLien($info,"modification catalogue");
        $catalogue = Catalogue::where('id', decrypt($id))->first();
        return view('Facturation.Catalogue.update', compact('catalogue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catalogue $catalogue)
    {
        $info = $this->userRepo->infoConnect();
        try {
            $catalogue->update([
                'num_ap' => $request->num_ap,
                'nom_partenaire' => $request->nom_partenaire,
                'type_partenaire_id' => $request->type_partenaire_id,
                'inclure_id' => $request->inclure_id,
                'compte_bancaire' => $request->compte_bancaire,
                'commentaire' => $request->commentaire,
                'mode_reversement_id' => $request->mode_reversement_id,
                'created_by' => $info,
            ]);
            $ancien = CatalogueHasSim::where('catalogue_id',$catalogue->id)->get();
            CatalogueHasSim::where('catalogue_id',$catalogue->id)->delete();
            foreach($request->car as $req)
            {
                CatalogueHasSim::create([
                    'catalogue_id' => $catalogue->id,
                    'taux_commission' => $req['taux_commission'],
                    'sim_head' => $req['sim_head'],
                    'identifiant_designation' => $req['id_designation'],
                    'onglet_facturation_id' => $req['onglet_facturation_id'],
                    'blacklist_c2c' => $req['blacklist_c2c']
                ]);
            }

            Tracking::create([
                'user' => $info,
                'action' => "a modifié un ancien catalogue num_ap: ".$catalogue->num_ap." ,nom_partenaire: ".
                            $catalogue->nom_partenaire." ,type_partenaire: ".$this->type_partenaire[$catalogue->type_partenaire_id]['libelle'].
                            " ,inclure: ".$this->inclure[$catalogue->inclure_id]['libelle']." ,taux_commission: ".$catalogue->taux_commission.
                            " ,compte_bancaire: ".$catalogue->compte_bancaire.
                            " ,mode_reversement: ".$this->mode_reversement[$catalogue->mode_reversement_id]['libelle'].
                            " ,sim_head et identifiant_designation: ".json_encode($ancien).
                            " nouvel valeur du catalogue num_ap: ".$request->num_ap." ,nom_partenaire: ".$request->nom_partenaire." ,type_partenaire: ".$this->type_partenaire[$request->type_partenaire_id]['libelle'].
                            " ,inclure: ".$this->inclure[$request->inclure_id]['libelle']." ,taux_commission: ".$request->taux_commission.
                            " ,compte_bancaire: ".$request->compte_bancaire." ,mode_reversement: ".$this->mode_reversement[$request->mode_reversement_id]['libelle'].
                            " ,sim_head, identifiant_designation, onglet_facturation_id et blacklist_c2c: ".json_encode($request->car),
                'ip_machine' => request()->ip(),
                'url' => url()->current()
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","Le catalogue existe déjà dans le système.");
            return redirect()->route('catalogue.edit', encrypt($catalogue->id));
        }
        session()->flash("message_success","Partenaire modifié avec succès.");
        return redirect()->route('catalogue.index');

    }    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalogue $catalogue)
    {
        $info = $this->userRepo->infoConnect();
        try{
            CatalogueHasSim::where('catalogue_id',$catalogue->id)->delete();
            $catalogue->delete();
            Tracking::create([
                'user' => $info,
                'action' => " a supprimé le catalogue num_ap: ".$catalogue->num_ap.", nom_partenaire: ".$catalogue->nom_partenaire.
                                ", type_partenaire: ".$this->type_partenaire[$catalogue->type_partenaire_id]['libelle'],
                'ip_machine' => request()->ip(),
                'url' => url()->current()
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","Impossible de supprimer le catalogue car il est lié à d'autres informations.");
            return redirect()->route('catalogue.index');
        }
        return redirect()->route('catalogue.index');
    }


    public function show($id)
    {
        $info = $this->userRepo->infoConnect();
        $this->visiteLien($info,"détails catalogue");

        $catalogue = Catalogue::with(['sim_designation'])->find($id);
        $type = $this->type_partenaire[$catalogue->type_partenaire_id]['libelle'];
        $inclure = $this->inclure[$catalogue->inclure_id]['libelle'];
        $mode_reversement = $this->mode_reversement[$catalogue->mode_reversement_id]['libelle'];
        // $onglet_facturation = $this->onglet_facturation[$catalogue->onglet_facturation_id]['libelle'];
        foreach($catalogue->sim_designation as $val)
        {
            $onglet_facturation[] = array(
                'onglet_facturation' => $this->onglet_facturation[$val->onglet_facturation_id]['libelle'],
            );
            $blacklist_c2c[] = array(
                'blacklist_c2c' => $this->blacklist_c2c[$val->blacklist_c2c]['libelle'],
            );
        }
        return response()->json(['data' => $catalogue, "type" => $type, "inclure" => $inclure,
                        "mode_reversement" => $mode_reversement,"onglet_facturation"=>$onglet_facturation,
                        "blacklist_c2c" => $blacklist_c2c]);
    }
    
}
