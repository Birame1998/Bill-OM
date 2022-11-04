<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\GestionStructure\Tracking;

class MetricaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function indexWithOneFolder($folderName,$fileName)
    {
        // Render perticular view file by foldername and filename
        if(view()->exists($folderName.".".$fileName)){
            return view($folderName.".".$fileName);
        }
        return abort('404');
    }
    public function indexWithTwoFolder($folderName1,$folderName2,$fileName)
    {
        // Render perticular view file by foldername and filename
        if(view()->exists($folderName1.".".$folderName2.".".$fileName)){
            return view($folderName1.".".$folderName2.".".$fileName);
        }
        return abort('404');
    }
    public function root()
    {
    	// Render perticular view file by foldername and filename
        return view('analytics/analytics-index');
    }
    public function logout()
    {
        $user = User::with(['structure'])->where('id',Auth::id())->first();
        $user = $user->prenom." ".$user->nom." [".$user->structure->libelle."]";
        Tracking::create([
            'user' => $user,
            'action' => " s'est déconnecté ",
            'ip_machine' => request()->ip(),
            'url' => url()->current()
        ]);
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
