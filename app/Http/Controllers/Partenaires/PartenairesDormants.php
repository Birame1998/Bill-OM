<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Models\Facturation\Catalogue;
use App\Models\Facturation\Facturation;

class PartenairesDormants extends Controller
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
        $this->visiteLien($info,"liste partenaire dormant");

        $facturation = Facturation::where("statut",1)->orderBy('date_transaction','desc')->get();
        $cpt=[];
        for ($i=0; $i < $facturation->count(); $i++) { 
            if($this->dateDifference($facturation[$i]->date_transaction)>30){
                array_push($cpt,$facturation[$i]->nom_partenaire);
            }
        }                        
       $partenaires=Catalogue::with(['sim_designation'])->whereBetween('nom_partenaire',$cpt)->orderBy('num_ap','desc')->paginate(15);
       return view('Facturation.Dormant.index',compact('partenaires'));

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
