<?php

namespace App\Http\Controllers\Securite;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\GestionStructure\Tracking;
use App\Http\Request\Securite\UserRequest;

class UserController extends Controller
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
        return view('Securite.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Securite.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $info = $this->userRepo->infoConnect();

        try {
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'login_windows' => $request->login_windows,
                'structure_id' => $request->structure_id,
                'role_base' => $request->role_id,
                'password' => bcrypt('passer'),
                'created_by' => Auth::id(),
            ]);
            $user->assignRole($request->role_id);

            Tracking::create([
                'user' => $info,
                'action' => $info." a créé l'utilisateur ".$request->prenom." ".$request->nom.
                            " avec le rôle ".Role::find($request->role_id)->name,
                'ip_machine' => request()->ip(),
                'url' => url()->current()
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","L'utilisateur existe déjà dans le système.");
            return redirect()->route('users.create');
        }
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $users = User::find($user);
        return view('Securite.users.show', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return Role::where('id', '!=', 1)->get();

        $user = $this->userRepo->findBy(decrypt($id));
        return view('Securite.users.update', compact(['user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $info = $this->userRepo->infoConnect();
        $user = $this->userRepo->findBy($id);
        try {
            $user->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'login_windows' => $request->login_windows,
                'structure_id' => $request->structure_id,
                'role_base' => $request->role_id,
                'created_by' => Auth::id(),
            ]);
            $user->roles()->sync($request->role_id);
            Tracking::create([
                'user' => $info,
                'action' => $info." a modifié l'utilisateur ".$user->prenom." ".$user->nom,
                'ip_machine' => request()->ip(),
                'url' => url()->current()
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","L'utilisateur existe déjà dans le système.");
            return redirect()->route('users.edit',encrypt($user->id));
        }
        return redirect()->route('users.index');
    }

    public function updateStatus(Request $request)
    {
        $info = $this->userRepo->infoConnect();
        $user = User::find($request->user_id);
        if($request->status==1){
            $user->is_active = 1;
            $user->save();
            Tracking::create([
                'user' => $info,
                'action' => $info." a activé l'utilisateur ".$user->prenom." ".$user->nom,
                'ip_machine' => request()->ip(),
                'url' => url()->current()
            ]);
            return response()->json(['message' => 'Utilisateur activé avec succés !', 'color'=> 'success']);
        }
        else{
            $user->is_active = 0;
            $user->save();
            Tracking::create([
                'user' => $info,
                'action' => $info." a bloqué l'utilisateur ".$user->prenom." ".$user->nom,
                'ip_machine' => request()->ip(),
                'url' => url()->current()
            ]);
            return response()->json(['message' => 'Utilisateur bloqué avec succés !', 'color'=> 'danger']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $info = $this->userRepo->infoConnect();
        try{
            $user->delete();
            Tracking::create([
                'user' => $info,
                'action' => $info." a supprimé l'utilisateur ".$user->prenom." ".$user->nom,
                'ip_machine' => request()->ip(),
                'url' => url()->current()
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash("message","Impossible de supprimer cet utilisateur car il est lié à d'autres informations.");
            return redirect()->route('users.index');
        }
        return redirect()->route('users.index');
    }

}
