<?php

namespace App\Http\Controllers\StructureOFMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\GestionStructure\Tracking;
use App\Models\GestionStructure\Type_structure;

class TypeStructureController extends Controller
{
    private $userRepo;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type_structure = Type_structure::orderBy('id','desc')->get();
        return view('structureOfms.TypeStructure.index',compact('type_structure'));
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
        try{
            Type_structure::create([
                'libelle' => $request->libelle,
                'description' => $request->description,
            ]);
            Tracking::create([
                'user' => $info,
                'libelle' => $info." a créé le type ".$request->libelle,
                'ip_machine' => request()->ip(),
                'created_by' => Auth::id()
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","Le type existe déjà dans le système.");
        }
        return redirect()->route('types_structure.index');
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
    public function update(Request $request)
    {
        $type= Type_structure::where('id',$request->id)->first();
        $info = $this->userRepo->infoConnect();
        try{
            $type->update([
                'libelle' => $request->libelle,
                'description' => $request->description,
            ]);
            Tracking::create([
                'user' => $info,
                'libelle' => $info." a modifié le type ".$request->libelle,
                'ip_machine' => request()->ip(),
                'created_by' => Auth::id()
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","Le type existe déjà dans le système.");
        }
        return redirect()->route('types_structure.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $info = $this->userRepo->infoConnect();
        $type = Type_structure::where('id',$id)->first();
        try{
            $type->delete();
            Tracking::create([
                'user' => $info,
                'libelle' => $info." a supprimé le ".$type->libelle,
                'ip_machine' => request()->ip(),
                'created_by' => Auth::id()
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","Impossible de supprimer le type car il est lié à d'autres structures.");
        }
        return redirect()->route('types_structure.index');
    }
}
