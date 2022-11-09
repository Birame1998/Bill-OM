<?php

namespace App\Http\Controllers\Securite;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\GestionStructure\Tracking;

class InterimController extends Controller
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
        if (Auth::user()->hasRole(['Super Admin'])){
            $role = Role::whereIn('id', [3,5,7,8,10,12,14,15])->get();
            $interim = User::with(['roles'])->where('id', '!=', 1)->where('id', '!=', Auth::id())
                        ->whereNotNull('date_fin_interim')->get();

            $users_interim = User::with(['roles'])->where('id', '!=', 1)
                                ->where('id', '!=', Auth::id())
                                ->whereNull('date_fin_interim')->get();

        }
        elseif(Auth::user()->hasRole(['DORESPOF', 'DORESPOF_INTERIMDOCHEFDEPT'])){
            $role = Role::whereIn('id', [5, 7])->get();
            $interim = User::with(['roles'])->role(['DOCHEFDEPT_INTERIMDORESPOF','METIERDO_INTERIMDORESPOF'])
                        ->where('id', '!=', 1)->where('id', '!=', Auth::id())
                        ->whereNotNull('date_fin_interim')->get();
            $users_interim = User::with(['roles'])->where('id', '!=', 1)
                                ->where('id', '!=', Auth::id())
                                ->where('structure_id',Auth::user()->structure_id)
                                ->whereNull('date_fin_interim')->get();
        }

        elseif(Auth::user()->hasRole(['DOCHEFDEPT', 'DOCHEFDEPT_INTERIMDORESPOF'])){
            $role = Role::whereIn('id', [3, 8])->get();
            $interim = User::with(['roles'])->role(['DORESPOF_INTERIMDOCHEFDEPT','METIERDO_INTERIMDOCHEFDEPT'])
                        ->where('id', '!=', 1)->where('id', '!=', Auth::id())
                        ->whereNotNull('date_fin_interim')->get();
            $users_interim = User::with(['roles'])->where('id', '!=', 1)
                                ->where('id', '!=', Auth::id())
                                ->where('structure_id',Auth::user()->structure_id)
                                ->whereNull('date_fin_interim')->get();
        }

        elseif(Auth::user()->hasRole(['DAFRESCOMPT', 'DAFRESCOMPT_INTERIMDAFCHEFDEPT'])){
            $role = Role::whereIn('id', [12, 14])->get();
            $interim = User::with(['roles'])->role(['DAFCHEFDEPT_INTERIMDAFRESCOMPT','METIERDAF_INTERIMDAFRESCOMPT'])
                        ->where('id', '!=', 1)->where('id', '!=', Auth::id())
                        ->whereNotNull('date_fin_interim')->get();
            $users_interim = User::with(['roles'])->where('id', '!=', 1)
                                ->where('id', '!=', Auth::id())->where('structure_id',Auth::user()->structure_id)
                                ->whereNull('date_fin_interim')->get();
        }

        elseif(Auth::user()->hasRole(['DAFCHEFDEPT', 'DAFCHEFDEPT_INTERIMDAFRESCOMPT'])){
            $role = Role::whereIn('id', [10, 15])->get();
            $interim = User::with(['roles'])->role(['DAFRESCOMPT_INTERIMDAFCHEFDEPT','METIERDAF_INTERIMDAFCHEFDEPT'])
                        ->where('id', '!=', 1)->where('id', '!=', Auth::id())
                        ->whereNotNull('date_fin_interim')->get();
            $users_interim = User::with(['roles'])->where('id', '!=', 1)
                                ->where('id', '!=', Auth::id())->where('structure_id',Auth::user()->structure_id)
                                ->whereNull('date_fin_interim')->get();
        }

        return view('Securite.Interim.index', compact('role','interim','users_interim'));
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
        $user = $this->userRepo->findBy($request->users_id);
        $user->update([
            'date_debut_interim' => Carbon::now()->format('Y-m-d'),
            'date_fin_interim' => Carbon::createFromFormat('d/m/Y', $request->date_fin)->format('Y-m-d'),
        ]);
        $user->roles()->sync($request->role_id);
        $role = Role::findById($request->role_id);
        Tracking::create([
            'user' => $info,
            'action' => $info." a ajouté l'utilisateur ".$user->prenom." ".$user->nom." comme intérim avec le rôle ".$role->description." jusqu'à la date du ".$request->date_fin,
            'ip_machine' => request()->ip(),
            'url' => url()->current()
        ]);
        return redirect()->route('interim.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $interim = User::with(['roles'])->where('id', $id)->first();
        return response()->json(['data' => $interim]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $info = $this->userRepo->infoConnect();
        $user = $this->userRepo->findBy($request->users_id);
        $user->update([
            'date_debut_interim' => Carbon::now()->format('Y-m-d'),
            'date_fin_interim' => Carbon::createFromFormat('d/m/Y', $request->date_fin)->format('Y-m-d'),
        ]);
        $user->roles()->sync($request->role_id);
        $role = Role::findById($request->role_id);

        Tracking::create([
            'user' => $info,
            'action' => $info." a modifié l'utilisateur intérim ".$user->prenom." ".$user->nom." avec le rôle ".$role->description." jusqu'à la date du ".$request->date_fin,
            'ip_machine' => request()->ip(),
            'url' => url()->current()
        ]);
        return redirect()->route('interim.index');
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
        $user = $this->userRepo->findBy($id);
        $user->update([
            'date_debut_interim' => null,
            'date_fin_interim' => null,
        ]);
        $user->roles()->sync($user->role_base);

        Tracking::create([
            'user' => $info,
            'action' => $info." a annulé le rôle d'intérim de ".$user->prenom." ".$user->nom,
            'ip_machine' => request()->ip(),
            'url' => url()->current()
        ]);
        return redirect()->route('interim.index');
    }
}
