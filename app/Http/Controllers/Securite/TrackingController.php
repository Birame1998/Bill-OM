<?php

namespace App\Http\Controllers\Securite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GestionStructure\Tracking;


class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracking = Tracking::orderBy('id','desc')->get();
        return view('Securite.tracking.index',compact('tracking'));
    }

    // public function index_motif()
    // {
    //     $fiche = FicheValider::with('fiche_controle')->get();
    //     return view('Securite.tracking.index_motif',compact('fiche'));
    // }

    // public function show_motif($id)
    // {
    //     $fiche = TrackingMotifModif::where('fiche_id', decrypt($id))->get();
    //     return view('Securite.tracking.show_motif',compact('fiche'));
    // }

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
