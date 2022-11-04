<?php

namespace App\Http\Controllers\Securite;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\GestionStructure\Tracking;
use Spatie\Permission\Exceptions\RoleAlreadyExists;

class RoleController extends Controller
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
        return view('Securite.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permToRubrique = Permission::where('tag', 'rubrique')->get();
        $permsOnTracking = Permission::where('tag', 'tracking')->get();
        $permsOnUsers = Permission::where('tag', 'user')->get();
        $permsOnRoles = Permission::where('tag', 'role')->get();
        $permsOnPermissions = Permission::where('tag', 'permission')->get();
        $permsOnFacture = Permission::where('tag', 'facture')->get();

        return view('Securite.roles.create', compact('permsOnUsers','permsOnRoles','permsOnPermissions',
                                'permsOnTracking','permToRubrique','permsOnFacture'));
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
            $role = Role::create([
                'name' => $request->libelle,
                'description' => $request->description,
                'created_by' => Auth::id()
            ]);

            if ($request->permissions) {
                $role->syncPermissions($request->permissions);
            }
            Tracking::create([
                'user' => $info,
                'action' => $info." a créé le rôle ".$request->libelle,
                'ip_machine' => request()->ip(),
                'url' => url()->current()
            ]);

        } catch (RoleAlreadyExists $e) {
            session()->flash("message","Le libellé du rôle existe déjà dans le système.");
            return redirect()->route('roles.create');
        }
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $id)
    {
        return view('Securite.roles.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roleSelect = array();
        $ancienRole = Role::with(['permissions'])->where('id', decrypt($id))->get();
        foreach ($ancienRole[0]->permissions as $val)
        {
            $roleSelect[] = $val->id ;
        }
        $permToRubrique = Permission::where('tag', 'rubrique')->get();
        $permsOnTracking = Permission::where('tag', 'tracking')->get();
        $permsOnUsers = Permission::where('tag', 'user')->get();
        $permsOnRoles = Permission::where('tag', 'role')->get();
        $permsOnPermissions = Permission::where('tag', 'permission')->get();
        $permsOnFacture = Permission::where('tag', 'facture')->get();

        return view('Securite.roles.create', compact('permsOnUsers','permsOnRoles','permsOnPermissions',
                                'permsOnTracking','permToRubrique','permsOnFacture'));
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
        $role= Role::where('id',$id)->first();
        $info = $this->userRepo->infoConnect();
        try{
            $role->update([
                'name' => $request->libelle,
                'description' => $request->description,
                'created_by' => Auth::id()
            ]);

            if ($request->permissions) {
                $role->syncPermissions($request->permissions);
            }

            Tracking::create([
                'user' => $info,
                'libelle' => $info." a modifié le rôle ".$request->libelle,
                'ip_machine' => request()->ip(),
                'created_by' => Auth::id(),
                'url' => url()->current()
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","Le libellé du rôle existe déjà dans le système.");
            return redirect()->route('roles.edit',encrypt($role->id));
        }
        return redirect()->route('roles.index');
    }

    public function updatePermissions(Role $role, $permission_id)
    {
        //$this->role = Role::findById($role_id);

        $this->permission = Permission::findById($permission_id);

        //dd($this->role);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $info = $this->userRepo->infoConnect();
        try{
            $role->delete();
            Tracking::create([
                'user' => $info,
                'libelle' => $info." a supprimé le ".$role->name,
                'ip_machine' => request()->ip(),
                'created_by' => Auth::id(),
                'url' => url()->current()
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","Impossible de supprimer le rôle car il est lié à des utilisateurs.");
            return redirect()->route('roles.index');
        }
        return redirect()->route('roles.index');
    }

}

