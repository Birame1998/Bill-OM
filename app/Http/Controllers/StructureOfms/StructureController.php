<?php

namespace App\Http\Controllers\StructureOFMS;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

use App\Models\GestionStructure\Tracking;
use App\Models\GestionStructure\Structure;

class StructureController extends Controller
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
        $structure = Structure::with(['structure_parent','type_structure','directeur'])->get()->append('liste_structure');
        return view('StructureOfms.Structure.index',compact('structure'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('StructureOfms.Structure.create');
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
            Structure::create([
                'libelle' => $request->libelle,
                'description' => $request->description,
                'directeur_id' => $request->directeur_id,
                'type_structure_id' => $request->type_structure_id,
                'structure_parent_id' => $request->structure_parent_id,
                'created_by' => Auth::id()
            ]);
            Tracking::create([
                'user' => $info,
                'libelle' => $info." a créé la structure ".$request->libelle,
                'ip_machine' => request()->ip(),
                'created_by' => Auth::id()
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","La structure existe déjà ou Le responsable est déjà rattaché à une structure.");
            return redirect()->route('structures.create');
        }
        return redirect()->route('structures.index');
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
        $struct_update= Structure::where('id',decrypt($id))->first();
        $structures = Structure::where('id','!=',$struct_update->id)->get();
        return view('StructureOfms.Structure.update', compact('structures','struct_update'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Structure $structure)
    {
        $info = $this->userRepo->infoConnect();

        try{
            $structure->update([
                'libelle' => $request->libelle,
                'description' => $request->description,
                'directeur_id' => $request->directeur_id,
                'type_structure_id' => $request->type_structure_id,
                'structure_parent_id' => $request->structure_parent_id,
                'created_by' => Auth::id()
            ]);
            Tracking::create([
                'user' => $info,
                'libelle' => $info." a modifié la structure ".$request->libelle,
                'ip_machine' => request()->ip(),
                'created_by' => Auth::id()
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","La structure existe déjà ou Le responsable est déjà rattaché à une structure.");
            return redirect()->route('structures.edit',encrypt($structure->id));
        }
        return redirect()->route('structures.index');
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
        $structure = Structure::where('id',$id)->first();
        if(User::where('structure_id',$id)->first()){
            session()->flash("message","Impossible de supprimer la structure car elle est liée à d'autres utilisateurs.");
            return redirect()->route('structures.index');
        }
        else{
            $structure->delete();
            Tracking::create([
                'user' => $info,
                'libelle' => $info." a supprimé la structure ".$structure->libelle,
                'ip_machine' => request()->ip(),
                'created_by' => Auth::id()
            ]);
        }
        return redirect()->route('structures.index');
    }

}
