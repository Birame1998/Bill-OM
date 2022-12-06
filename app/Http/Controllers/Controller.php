<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use App\Models\Facturation\Catalogue;
use App\Models\Facturation\Facturation;
use App\Models\Facturation\HorsCatalogue;
use App\Models\GestionStructure\Tracking;
use App\Models\Facturation\CatalogueHasSim;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $inclure = array(
        1 => array('id' => 1, 'libelle' => 'Oui'),
        2 => array('id' => 2, 'libelle' => 'Non')
    );
    public $blacklist_c2c = array(
        1 => array('id' => 1, 'libelle' => 'Oui'),
        2 => array('id' => 2, 'libelle' => 'Non')
    );

    public $type_partenaire = array(
        1 => array('id' => 1, 'libelle' => 'Don'),
        2 => array('id' => 2, 'libelle' => 'Don et cotisation'),
        3 => array('id' => 3, 'libelle' => 'Donation'),
        4 => array('id' => 4, 'libelle' => 'Facturier'),
        5 => array('id' => 5, 'libelle' => 'Marchand')
    );

    public $mode_reversement = array(
        6 => array('id' => 6, 'libelle' => 'Reversement classique'),
        1 => array('id' => 1, 'libelle' => 'Cash out kiosque'),
        2 => array('id' => 2, 'libelle' => 'Facturier'),
        3 => array('id' => 3, 'libelle' => 'Fusion des comptes'),
        4 => array('id' => 4, 'libelle' => 'OMBA marchand'),
        5 => array('id' => 5, 'libelle' => 'Pas de facture'),
    );

    public $onglet_facturation = array(
        5 => array('id' => 5, 'libelle' => 'Facturier'),
        1 => array('id' => 1, 'libelle' => 'API'),
        2 => array('id' => 2, 'libelle' => 'Canal'),
        3 => array('id' => 3, 'libelle' => 'Cash out kiosque'),
        4 => array('id' => 4, 'libelle' => 'Dual wallet'),
        6 => array('id' => 6, 'libelle' => 'Fusion des comptes'),
        7 => array('id' => 7, 'libelle' => 'Marchands'),
        8 => array('id' => 8, 'libelle' => 'Mensuel'),
        9 => array('id' => 9, 'libelle' => 'OMBA marchand'),
        10 => array('id' => 10, 'libelle' => 'Pas de factures'),
        11 => array('id' => 11, 'libelle' => 'Premier'),
        12 => array('id' => 12, 'libelle' => 'PTUPS'),
        13 => array('id' => 13, 'libelle' => 'Restaurants'),
        14 => array('id' => 14, 'libelle' => 'Autres restos'),
        15 => array('id' => 15, 'libelle' => 'Sonatel mobile'),
        16 => array('id' => 16, 'libelle' => 'Soxla Paydunya'),
        17 => array('id' => 17, 'libelle' => 'Woyofal'),
        18 => array('id' => 18, 'libelle' => 'Promobile'),
        19 => array('id' => 19, 'libelle' => 'Sonatel')
    );

    public $statut_validation = array(
        1 => array('id' => 1, 'libelle' => 'En attente de validation DO', 'couleur' => 'orange'),
        2 => array('id' => 2, 'libelle' => 'Facture(s) validée(s) par DO', 'couleur' => 'bleu'),
        3 => array('id' => 3, 'libelle' => 'Facture(s) rejetée(s) par DO', 'couleur' => 'rouge')
    );



    public function visiteLien($user,$page){
        Tracking::create([
            'user' => $user,
            'action' => " a visité la page ".$page,
            'ip_machine' => request()->ip(),
            'url' => url()->current()
        ]);
    }
    public function rechercheLien($user,$page){
        Tracking::create([
            'user' => $user,
            'action' => $page,
            'ip_machine' => request()->ip(),
            'url' => url()->current()
        ]);
    }

    // public function notifiation(){
    //     $from_charger = Facturation::orderBy('date_transaction','desc')->first()->date_transaction ?? null;
    //     $from_charger = Carbon::createFromFormat('Ymd',$from_charger)->addDays(1)->format('Y-m-d');
    //     $to_charger = date("Y-m-d", strtotime( '-1 days' ) );

    //     $period_not_charger = CarbonPeriod::create($from_charger, $to_charger);
    //     $notification = [];
    //     foreach ($period_not_charger as $date) {
    //         $notification[] = ["type"=>"charger","date"=> Carbon::createFromFormat('Y-m-d H:i:s',date($date))->format('Y-m-d')];
    //     }
    //     $period_not_validate = Facturation::where('statut',1)->orderBy('date_transaction','desc')->distinct()->get(['date_transaction']);
    //     foreach ($period_not_validate as $date) {
    //         $notification[] = ["type"=>"valider","date"=>Carbon::createFromFormat('Ymd',$date->date_transaction)->format('Y-m-d')];
    //     }
    //     return $notification;
    // }
    public function recherche($nom_partenaire,$dates){
        $user = User::with(['structure'])->where('id',Auth::id())->first();
        $user = $user->prenom." ".$user->nom." [".$user->structure->libelle."]";
        $from = Carbon::createFromFormat('d/m/Y',explode("-",preg_replace('/\s+/', '', $dates))[0])->format('Ymd');
        $to = Carbon::createFromFormat('d/m/Y',explode("-",preg_replace('/\s+/', '', $dates))[1])->format('Ymd');
        if($nom_partenaire!=""){
            $nom = Catalogue::where('id',$nom_partenaire)->first()->nom_partenaire;
            $this->rechercheLien($user,"a recherché des factures avec le partenaire $nom à l'intervalle $dates");
        }
        else{
            $this->rechercheLien($user,"a recherché des factures à l'intervalle $dates");
        }

        $facturation = Facturation::where("statut",1)->whereBetween('date_transaction', [$from, $to]);
        if($nom_partenaire!="") {
            $nom = Catalogue::where('id',$nom_partenaire)->first()->nom_partenaire;
            $facturation = $facturation->where('nom_partenaire', 'LIKE', "%{$nom}%");
        }

        $facturation = $facturation->get();

        return array($facturation,$nom_partenaire,$dates);
    }


    public function __construct(){
        $nbre_facture_envalidation = Facturation::where("statut",1)->count();
        $nbre_facture_valide = Facturation::where("statut",2)->count();
        $nbre_facture_rejete = Facturation::where("statut",3)->count();
        $nbre_hors_catalogue = HorsCatalogue::count();
        $maxDate = Facturation::orderBy('date_transaction','desc')->first()->date_transaction ?? null;
        View::share(['inclure' => $this->inclure, 'blacklist_c2c'=> $this->blacklist_c2c, 'type_partenaire' => $this->type_partenaire,
            'mode_reversement' => $this->mode_reversement, 'statut_validation' => $this->statut_validation,
            'onglet_facturation' => $this->onglet_facturation, 'nbre_facture_envalidation' => $nbre_facture_envalidation,
            'nbre_facture_valide' => $nbre_facture_valide, 'maxDate' =>$maxDate, 'notification' => null,
            'nbre_facture_rejete' => $nbre_facture_rejete, 'nbre_hors_catalogue' => $nbre_hors_catalogue
        ]);
        // 'notification' => json_encode($this->notifiation())
    }
}
