<?php

namespace App\Http\Controllers\Facturation;

use ZipArchive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use File;
use App\Models\Facturation\Facturation;
use Illuminate\Support\Facades\Storage;

class FacturationValideController extends Controller
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
        // $ra= range(1, 33);
        // $b = array(19,20,21,22, 23,28,29,30,31,32,33);
        // return $tab = array_diff($ra, $b);
        $info = $this->userRepo->infoConnect();
        $this->visiteLien($info,"liste facture en validation");

        $facturation = Facturation::where("statut",2)->get();
        return view('Facturation.Facturation.index_valide',compact('facturation'));
    }

    public function search(Request $request){
        $recherche = $this->recherche($request->nom_partenaire,$request->dates);
        $facturation = $recherche[0];
        $nom_partenaire = $recherche[1];
        $dates = $recherche[2];
        return view('Facturation.Facturation.index_valide',compact('facturation','nom_partenaire', 'dates'));
    }


    public function exportUnique($selected_id)
    {
            $mytime = Carbon::now()->format('Ymd-Hi');
            $facture = Facturation::where("statut",2)->whereIn("id", $selected_id)->get();
            $facture_sum = Facturation::where("statut",2)->whereIn("id", $selected_id)->sum("a_reverser");
            $data = [
                'date' => date('m/d/Y'),
                'facture' => $facture,
                'facture_sum' => $facture_sum
            ];
            $pdf = PDF::loadView('Facturation.Facturation.pdf', $data)->setPaper('a4', 'landscape');
            // $path = public_path("export\\");
            $onglet_facturation = $this->onglet_facturation[$facture[0]->onglet_facturation_id]['libelle'];
            // $pdf->save($path.'/'.'invoice1.pdf');
            return $pdf->download($onglet_facturation.'_'.$mytime.'.pdf');

    }

    public function export_pdf(Request $request)
    {
        if($request->selected_id){
            $mytime = Carbon::now()->format('Ymd-Hi');

            if(count($request->selected_id)==1){
            return $this->exportUnique($request->selected_id);
            }
            elseif(count($request->selected_id)!=1){
                $facture_array = Facturation::where("statut",2)->whereIn("id", $request->selected_id)
                                    ->distinct('onglet_facturation_id')->pluck('onglet_facturation_id')->toArray();
                if(count($facture_array)!=1){
                    File::cleanDirectory(public_path("export\\"));
                    foreach($facture_array as $val){
                        $facture = Facturation::where("statut",2)->whereIn("id", $request->selected_id)
                            ->where("onglet_facturation_id", $val)->get();
                        $facture_sum = Facturation::where("statut",2)->whereIn("id", $request->selected_id)
                                        ->where("onglet_facturation_id", $val)->sum("a_reverser");

                        $data = [
                            'date' => date('m/d/Y'),
                            'facture' => $facture,
                            'facture_sum' => $facture_sum
                        ];
                        $pdf = PDF::loadView('Facturation.Facturation.pdf', $data)->setPaper('a4', 'landscape');
                        $path = public_path("export\\");
                        $onglet_facturation = $this->onglet_facturation[$facture[0]->onglet_facturation_id]['libelle'];
                        $pdf->save($path.'/'.$onglet_facturation.'_'.$mytime.'.pdf');

                        // $pdf->download('inv'.$val.'.pdf');
                    }
                    $zip = new \ZipArchive();
                    $fileName = 'export_facture_'.$mytime.'.zip';
                    $path = public_path('export\\').$fileName;

                    if ($zip->open($path, \ZipArchive::CREATE)== TRUE)
                    {
                        $files = File::files(public_path('export\\'));
                        foreach ($files as $key => $value){
                            $relativeName = basename($value);
                            $zip->addFile($value, $relativeName);
                        }
                        $zip->close();
                    }
                    return response()->download($path);
                }
                else{
                    return $this->exportUnique($request->selected_id);
                }
            }
            else{
                session()->flash("message","Aucune facture n'a été selectionnée.");
                return redirect()->route('facturation_valide.index');
            }
        }
        else{
            session()->flash("message","Aucune facture n'a été selectionnée.");
            return redirect()->route('facturation_valide.index');
        }
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
        return $request;
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
        $this->visiteLien($info,"détail facture validée");
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
